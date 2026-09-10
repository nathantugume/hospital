<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointments\ProcessAppointmentRequest;
use App\Http\Requests\Appointments\StorePatientAppointmentRequest;
use App\Models\Appointment;
use App\Models\AppointmentRequest;
use App\Models\Staff;
use App\Services\AppointmentSchedulingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AppointmentRequestController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', AppointmentRequest::class);
        $query = AppointmentRequest::forCompany($request->user())->with(['patient', 'doctor'])->latest('requested_date');
        if ($request->user()->isPatient()) {
            $query->where('patient_id', $request->user()->patient_id);
        }

        return view('appointment-requests.index', ['requests' => $query->paginate(20)->withQueryString()]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', AppointmentRequest::class);
        return view('appointment-requests.create', [
            'doctors' => Staff::forCompany($request->user())
                ->whereNotNull('specialization')
                ->where('status', 'Active')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get(),
        ]);
    }

    public function store(StorePatientAppointmentRequest $request): RedirectResponse
    {
        $patient = $request->user()->patient;
        abort_unless($patient, 403);
        $data = $request->validated();

        if (! empty($data['doctor_id'])) {
            abort_unless(Staff::query()
                ->where('company_id', $patient->company_id)
                ->whereKey($data['doctor_id'])
                ->whereNotNull('specialization')
                ->where('status', 'Active')
                ->exists(), 422);
        }

        AppointmentRequest::create($data + [
            'company_id' => $patient->company_id,
            'patient_id' => $patient->id,
            'status' => 'Pending',
        ]);

        return redirect()->route('web.appointment-requests.index')->with('status', 'Appointment request submitted.');
    }

    public function process(ProcessAppointmentRequest $request, AppointmentRequest $appointmentRequest, AppointmentSchedulingService $scheduling): RedirectResponse
    {
        abort_unless($appointmentRequest->status === 'Pending', 409);

        if ($request->validated('decision') === 'Rejected') {
            $appointmentRequest->update(['status' => 'Rejected']);

            return back()->with('status', 'Request rejected.');
        }

        $attributes = $scheduling->attributes([
            'patient_id' => $appointmentRequest->patient_id,
            'doctor_id' => $appointmentRequest->doctor_id,
            'department_id' => null,
            'service_id' => null,
            'date' => $appointmentRequest->requested_date->toDateString(),
            'start_time' => $appointmentRequest->requested_time,
            'duration_minutes' => 30,
            'type' => $appointmentRequest->type ?: 'Consultation',
            'status' => 'Confirmed',
            'notes' => $appointmentRequest->notes,
        ], $appointmentRequest->company_id);

        $appointment = DB::transaction(function () use ($attributes, $scheduling, $appointmentRequest): Appointment {
            $appointmentRequest = AppointmentRequest::query()->lockForUpdate()->findOrFail($appointmentRequest->id);
            abort_unless($appointmentRequest->status === 'Pending', 409);
            $scheduling->assertDoctorAvailable($attributes);
            $appointment = Appointment::create(collect($attributes)->except('duration_minutes')->all());
            $appointmentRequest->update(['status' => 'Approved']);

            return $appointment;
        });

        return redirect()->route('web.appointments.show', $appointment)->with('status', 'Request approved and appointment created.');
    }
}
