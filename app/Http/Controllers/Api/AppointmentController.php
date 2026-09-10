<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointments\StoreAppointmentRequest;
use App\Http\Requests\Appointments\UpdateAppointmentRequest;
use App\Http\Resources\Appointments\Resource;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Staff;
use App\Services\AppointmentSchedulingService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Appointment::class);

        $query = Appointment::query()->forCompany($request->user())->with(['patient', 'doctor', 'department', 'service']);

        if ($request->user()->isPatient()) {
            $query->where('patient_id', $request->user()->patient_id);
        }
        if ($request->user()->isDoctor()) {
            $query->where('doctor_id', $request->user()->staff_id);
        }

        if ($search = $request->input('search')) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('date', $date);
        }

        if ($doctorId = $request->input('doctor_id')) {
            $query->where('doctor_id', $doctorId);
        }

        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('date', [$request->input('from'), $request->input('to')]);
        }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest('date')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Appointment list retrieved.',
            'data' => Resource::collection($items->items()),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    public function store(StoreAppointmentRequest $request, AppointmentSchedulingService $scheduling): JsonResponse
    {
        $this->authorize('create', Appointment::class);
        $data = $request->validated();
        $patient = Patient::forCompany($request->user())->find($data['patient_id']);
        abort_unless($patient, 422);

        if ($request->user()->isDoctor()) {
            abort_unless($request->user()->staff_id, 403);
            $data['doctor_id'] = $request->user()->staff_id;
        }

        if (! empty($data['doctor_id'])) {
            abort_unless(Staff::query()->where('company_id', $patient->company_id)->whereKey($data['doctor_id'])->whereNotNull('specialization')->exists(), 422);
        }

        $duration = 30;
        if (! empty($data['end_time'])) {
            $duration = Carbon::parse($data['start_time'])->diffInMinutes(Carbon::parse($data['end_time']));
        }
        $attributes = $scheduling->attributes([
            ...$data,
            'department_id' => null,
            'service_id' => null,
            'duration_minutes' => $duration,
            'status' => $data['status'] ?? 'Pending',
            'notes' => $data['notes'] ?? null,
        ], $patient->company_id);

        $appointment = DB::transaction(function () use ($scheduling, $attributes): Appointment {
            $scheduling->assertDoctorAvailable($attributes);

            return Appointment::create(collect($attributes)->except('duration_minutes')->all());
        });
        $appointment->load(['patient', 'doctor', 'department']);

        return $this->resource(new Resource($appointment), 'Appointment created.', 201);
    }

    public function show(Request $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('view', $appointment);
        $appointment->load(['patient', 'doctor', 'department', 'service']);
        return $this->resource(new Resource($appointment));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment, AppointmentSchedulingService $scheduling): JsonResponse
    {
        $this->authorize('update', $appointment);
        $this->updateAppointment($appointment, $request->validated(), $scheduling);
        $appointment->load(['patient', 'doctor', 'department']);
        return $this->resource(new Resource($appointment), 'Appointment updated.');
    }

    public function destroy(Request $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('delete', $appointment);
        $appointment->delete();
        return response()->json(['success' => true, 'message' => 'Appointment deleted.']);
    }

    public function confirm(Request $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('update', $appointment);
        $this->assertStatusTransition($appointment, 'Confirmed');
        $appointment->update(['status' => 'Confirmed']);
        return $this->resource(new Resource($appointment), 'Appointment confirmed.');
    }

    public function cancel(Request $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('update', $appointment);
        $this->assertStatusTransition($appointment, 'Cancelled');
        $appointment->update(['status' => 'Cancelled']);
        return $this->resource(new Resource($appointment), 'Appointment cancelled.');
    }

    public function reschedule(UpdateAppointmentRequest $request, Appointment $appointment, AppointmentSchedulingService $scheduling): JsonResponse
    {
        $this->authorize('update', $appointment);
        $this->updateAppointment($appointment, $request->only(['date', 'start_time']), $scheduling);
        return $this->resource(new Resource($appointment), 'Appointment rescheduled.');
    }

    public function calendarEvents(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Appointment::class);
        $appointments = Appointment::forCompany($request->user())->with(['patient:id,first_name,last_name', 'doctor:id,first_name,last_name'])
            ->whereBetween('date', [$request->input('start', now()->startOfMonth()), $request->input('end', now()->endOfMonth())])
            ->when($request->user()->isPatient(), fn ($query) => $query->where('patient_id', $request->user()->patient_id))
            ->when($request->user()->isDoctor(), fn ($query) => $query->where('doctor_id', $request->user()->staff_id))
            ->get();

        $events = $appointments->map(function ($apt) {
            return [
                'id' => $apt->id,
                'title' => $apt->patient->full_name . ' — ' . $apt->type,
                'start' => $apt->date . 'T' . $apt->start_time,
                'end' => $apt->date . 'T' . ($apt->end_time ?? '00:00:00'),
                'status' => $apt->status,
                'patient' => $apt->patient->full_name,
                'doctor' => $apt->doctor?->full_name,
            ];
        });

        return response()->json(['success' => true, 'data' => $events]);
    }

    private function updateAppointment(Appointment $appointment, array $data, AppointmentSchedulingService $scheduling): void
    {
        if (isset($data['status']) && $data['status'] !== $appointment->status) {
            $this->assertStatusTransition($appointment, $data['status']);
        }

        if (isset($data['date']) || isset($data['start_time'])) {
            $attributes = $scheduling->attributes([
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'department_id' => $appointment->department_id,
                'service_id' => $appointment->service_id,
                'date' => $data['date'] ?? $appointment->date->toDateString(),
                'start_time' => $data['start_time'] ?? substr((string) $appointment->start_time, 0, 5),
                'duration_minutes' => max(1, (int) $appointment->duration ?: 30),
                'type' => $appointment->type,
                'status' => $data['status'] ?? $appointment->status,
                'notes' => $data['notes'] ?? $appointment->notes,
            ], $appointment->company_id);

            DB::transaction(function () use ($appointment, $attributes, $scheduling): void {
                $scheduling->assertDoctorAvailable($attributes, $appointment->id);
                $appointment->update(collect($attributes)->except('duration_minutes')->all());
            });

            return;
        }

        $appointment->update($data);
    }

    private function assertStatusTransition(Appointment $appointment, string $status): void
    {
        $allowed = ['Pending' => ['Confirmed', 'Cancelled'], 'Confirmed' => ['Completed', 'Cancelled', 'No-Show']];

        if (! in_array($status, $allowed[$appointment->status] ?? [], true)) {
            throw ValidationException::withMessages(['status' => "A {$appointment->status} appointment cannot be changed to {$status}."]);
        }
    }
}
