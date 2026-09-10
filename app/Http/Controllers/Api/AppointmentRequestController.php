<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentRequest;
use App\Models\Staff;
use App\Services\AppointmentSchedulingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AppointmentRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', AppointmentRequest::class);
        $query = AppointmentRequest::forCompany($request->user())->with(['patient', 'doctor'])->latest('requested_date');

        if ($request->user()->isPatient()) {
            $query->where('patient_id', $request->user()->patient_id);
        }

        return $this->success($query->paginate(min((int) $request->input('per_page', 15), 100)), 'Appointment requests retrieved.');
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', AppointmentRequest::class);
        $patient = $request->user()->patient;
        abort_unless($patient, 403);
        $data = $request->validate([
            'doctor_id' => ['nullable', 'integer', 'exists:staff,id'],
            'requested_date' => ['required', 'date', 'after_or_equal:today'],
            'requested_time' => ['required', 'date_format:H:i'],
            'type' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! empty($data['doctor_id'])) {
            abort_unless(Staff::query()->where('company_id', $patient->company_id)->whereKey($data['doctor_id'])->whereNotNull('specialization')->where('status', 'Active')->exists(), 422);
        }

        $record = AppointmentRequest::create($data + [
            'company_id' => $patient->company_id,
            'patient_id' => $patient->id,
            'status' => 'Pending',
        ]);

        return $this->success($record->load(['patient', 'doctor']), 'Appointment request submitted.', 201);
    }

    public function update(Request $request, AppointmentRequest $appointmentRequest, AppointmentSchedulingService $scheduling): JsonResponse
    {
        $this->authorize('process', $appointmentRequest);
        abort_unless($appointmentRequest->status === 'Pending', 409);
        $decision = $request->validate(['decision' => ['required', Rule::in(['Approved', 'Rejected'])]])['decision'];

        if ($decision === 'Rejected') {
            $appointmentRequest->update(['status' => 'Rejected']);

            return $this->success($appointmentRequest, 'Appointment request rejected.');
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

        $appointment = DB::transaction(function () use ($appointmentRequest, $attributes, $scheduling): Appointment {
            $requestRecord = AppointmentRequest::query()->lockForUpdate()->findOrFail($appointmentRequest->id);
            abort_unless($requestRecord->status === 'Pending', 409);
            $scheduling->assertDoctorAvailable($attributes);
            $appointment = Appointment::create(collect($attributes)->except('duration_minutes')->all());
            $requestRecord->update(['status' => 'Approved']);

            return $appointment;
        });

        return $this->success(['request' => $appointmentRequest->fresh(), 'appointment' => $appointment], 'Appointment request approved.');
    }

    public function destroy(Request $request, AppointmentRequest $appointmentRequest): JsonResponse
    {
        $this->authorize('delete', $appointmentRequest);
        $appointmentRequest->delete();

        return $this->success(message: 'Appointment request deleted.');
    }
}
