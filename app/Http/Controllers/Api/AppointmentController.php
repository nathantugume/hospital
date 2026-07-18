<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointments\StoreAppointmentRequest;
use App\Http\Requests\Appointments\UpdateAppointmentRequest;
use App\Http\Resources\Appointments\Resource;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Appointment::class);

        $query = Appointment::query()->with(['patient', 'doctor', 'department', 'service']);

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

    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        $this->authorize('create', Appointment::class);
        $data = $request->validated();

        if (empty($data['code'])) {
            $data['code'] = 'APT-' . str_pad((string) (Appointment::max('id') + 1), 5, '0', STR_PAD_LEFT);
        }

        $appointment = Appointment::create($data);
        $appointment->load(['patient', 'doctor', 'department']);

        return $this->resource(new Resource($appointment), 'Appointment created.', 201);
    }

    public function show(Request $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('view', $appointment);
        $appointment->load(['patient', 'doctor', 'department', 'service']);
        return $this->resource(new Resource($appointment));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('update', $appointment);
        $appointment->update($request->validated());
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
        $appointment->update(['status' => 'Confirmed']);
        return $this->resource(new Resource($appointment), 'Appointment confirmed.');
    }

    public function cancel(Request $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('update', $appointment);
        $appointment->update(['status' => 'Cancelled']);
        return $this->resource(new Resource($appointment), 'Appointment cancelled.');
    }

    public function reschedule(UpdateAppointmentRequest $request, Appointment $appointment): JsonResponse
    {
        $this->authorize('update', $appointment);
        $appointment->update($request->only(['date', 'start_time', 'end_time']));
        return $this->resource(new Resource($appointment), 'Appointment rescheduled.');
    }

    public function calendarEvents(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Appointment::class);
        $appointments = Appointment::with(['patient:id,first_name,last_name', 'doctor:id,first_name,last_name'])
            ->whereBetween('date', [$request->input('start', now()->startOfMonth()), $request->input('end', now()->endOfMonth())])
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
}
