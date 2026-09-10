<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointments\StoreWebAppointmentRequest;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Staff;
use App\Services\AppointmentSchedulingService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Appointment::class);

        $query = Appointment::query()->forCompany($request->user())->with(['patient', 'doctor', 'department']);

        if ($request->user()->isPatient()) {
            $query->where('patient_id', $request->user()->patient_id);
        }
        if ($request->user()->isDoctor() && $request->user()->staff_id) {
            $query->where('doctor_id', $request->user()->staff_id);
        }

        $search = $request->string('search')->trim()->value();
        $status = $request->string('status')->trim()->value();

        $query
            ->when($search, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->whereHas('patient', fn ($query) => $query
                            ->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%"));
                });
            })
            ->when($status, fn ($query, string $status) => $query->where('status', $status))
            ->when($request->date('date'), fn ($query, $date) => $query->whereDate('date', $date))
            ->orderByDesc('date')
            ->orderBy('start_time');

        $appointments = $query->paginate(15)->withQueryString();
        $scope = Appointment::query()->forCompany($request->user());

        if ($request->user()->isPatient()) {
            $scope->where('patient_id', $request->user()->patient_id);
        }
        if ($request->user()->isDoctor() && $request->user()->staff_id) {
            $scope->where('doctor_id', $request->user()->staff_id);
        }

        $stats = [
            'today' => (clone $scope)->whereDate('date', today())->count(),
            'upcoming' => (clone $scope)->whereDate('date', '>=', today())->count(),
            'pending' => (clone $scope)->where('status', 'Pending')->count(),
            'completed' => (clone $scope)->where('status', 'Completed')->count(),
        ];

        return view('appointments.index', compact('appointments', 'stats'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Appointment::class);

        return view('appointments.create', $this->formData($request, new Appointment()));
    }

    public function calendar(Request $request): View
    {
        $this->authorize('viewAny', Appointment::class);
        $user = $request->user();
        $validated = $request->validate([
            'view' => ['nullable', Rule::in(['month', 'week', 'day'])],
            'date' => ['nullable', 'date'],
            'month' => ['nullable', 'date'],
        ]);
        $view = $validated['view'] ?? 'month';
        $selectedDate = Carbon::parse($validated['date'] ?? $validated['month'] ?? today())->startOfDay();

        [$rangeStart, $rangeEnd] = match ($view) {
            'day' => [$selectedDate->copy(), $selectedDate->copy()],
            'week' => [$selectedDate->copy()->startOfWeek(Carbon::SUNDAY), $selectedDate->copy()->endOfWeek(Carbon::SATURDAY)],
            default => [$selectedDate->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY), $selectedDate->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY)],
        };

        $appointments = Appointment::forCompany($user)
            ->with(['patient', 'doctor'])
            ->whereBetween('date', [$rangeStart, $rangeEnd])
            ->when($user->isPatient(), fn ($query) => $query->where('patient_id', $user->patient_id))
            ->when($user->isDoctor(), fn ($query) => $query->where('doctor_id', $user->staff_id))
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn (Appointment $appointment) => $appointment->date->toDateString());

        $days = collect(CarbonPeriod::create($rangeStart, $rangeEnd));
        $previousDate = match ($view) {
            'day' => $selectedDate->copy()->subDay(),
            'week' => $selectedDate->copy()->subWeek(),
            default => $selectedDate->copy()->subMonthNoOverflow(),
        };
        $nextDate = match ($view) {
            'day' => $selectedDate->copy()->addDay(),
            'week' => $selectedDate->copy()->addWeek(),
            default => $selectedDate->copy()->addMonthNoOverflow(),
        };

        return view('appointments.calendar', compact(
            'appointments', 'days', 'view', 'selectedDate', 'rangeStart', 'rangeEnd', 'previousDate', 'nextDate'
        ));
    }

    public function store(StoreWebAppointmentRequest $request, AppointmentSchedulingService $scheduling): RedirectResponse
    {
        $this->authorize('create', Appointment::class);
        $attributes = $this->appointmentAttributes($request, $request->validated(), $scheduling);

        $appointment = DB::transaction(function () use ($attributes, $scheduling): Appointment {
            $scheduling->assertDoctorAvailable($attributes);

            return Appointment::create($this->persistedAttributes($attributes));
        });

        return redirect()->route('web.appointments.show', $appointment)
            ->with('status', 'Appointment scheduled successfully.');
    }

    public function show(Appointment $appointment): View
    {
        $this->authorize('view', $appointment);
        $appointment->load(['patient', 'doctor', 'department', 'service']);

        return view('appointments.show', compact('appointment'));
    }

    public function edit(Request $request, Appointment $appointment): View
    {
        $this->authorize('update', $appointment);

        return view('appointments.edit', $this->formData($request, $appointment));
    }

    public function update(StoreWebAppointmentRequest $request, Appointment $appointment, AppointmentSchedulingService $scheduling): RedirectResponse
    {
        $this->authorize('update', $appointment);
        $validated = $request->validated();
        $validated['status'] = $appointment->status;
        $attributes = $this->appointmentAttributes($request, $validated, $scheduling);

        DB::transaction(function () use ($appointment, $attributes, $scheduling): void {
            $scheduling->assertDoctorAvailable($attributes, $appointment->id);
            $appointment->update($this->persistedAttributes($attributes));
        });

        return redirect()->route('web.appointments.show', $appointment)
            ->with('status', 'Appointment updated successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $this->authorize('update', $appointment);
        $validated = $request->validate(['status' => ['required', Rule::in(['Confirmed', 'Completed', 'Cancelled', 'No-Show'])]]);
        $allowedTransitions = [
            'Pending' => ['Confirmed', 'Cancelled'],
            'Confirmed' => ['Completed', 'Cancelled', 'No-Show'],
        ];

        if (! in_array($validated['status'], $allowedTransitions[$appointment->status] ?? [], true)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'status' => "A {$appointment->status} appointment cannot be changed to {$validated['status']}.",
            ]);
        }

        $appointment->update($validated);

        return back()->with('status', 'Appointment status updated.');
    }

    private function formData(Request $request, Appointment $appointment): array
    {
        $user = $request->user();
        $doctors = Staff::forCompany($user)->whereNotNull('specialization')->where('status', 'Active');

        if ($user->isDoctor()) {
            $doctors->whereKey($user->staff_id);
        }

        return [
            'appointment' => $appointment,
            'patients' => Patient::forCompany($user)->where('status', 'Active')->orderBy('first_name')->orderBy('last_name')->get(['id', 'code', 'first_name', 'last_name']),
            'doctors' => $doctors->orderBy('first_name')->orderBy('last_name')->get(['id', 'first_name', 'last_name', 'specialization']),
            'departments' => Department::forCompany($user)->where('status', 'Active')->orderBy('name')->get(['id', 'name']),
            'services' => Service::query()->where('status', 'Active')->whereHas('department', fn ($query) => $query->forCompany($user))->orderBy('name')->get(['id', 'name', 'department_id', 'duration']),
        ];
    }

    private function appointmentAttributes(Request $request, array $validated, AppointmentSchedulingService $scheduling): array
    {
        $user = $request->user();
        $patient = Patient::forCompany($user)->find($validated['patient_id']);
        abort_unless($patient, 422);
        $companyId = $patient->company_id;

        if ($user->isDoctor()) {
            abort_unless($user->staff_id, 403);
            $validated['doctor_id'] = $user->staff_id;
        }

        if (! empty($validated['doctor_id'])) {
            abort_unless(Staff::query()->where('company_id', $companyId)->whereKey($validated['doctor_id'])->whereNotNull('specialization')->exists(), 422);
        }
        if (! empty($validated['department_id'])) {
            abort_unless(Department::query()->where('company_id', $companyId)->whereKey($validated['department_id'])->exists(), 422);
        }
        if (! empty($validated['service_id'])) {
            abort_unless(Service::query()->whereKey($validated['service_id'])->whereHas('department', fn ($query) => $query->where('company_id', $companyId))->exists(), 422);
        }

        return $scheduling->attributes($validated, $companyId);
    }

    private function persistedAttributes(array $attributes): array
    {
        unset($attributes['duration_minutes']);

        return $attributes;
    }
}
