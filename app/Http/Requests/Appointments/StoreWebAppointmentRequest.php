<?php

namespace App\Http\Requests\Appointments;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWebAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $appointment = $this->route('appointment');

        return $appointment instanceof Appointment
            ? ($this->user()?->can('update', $appointment) ?? false)
            : ($this->user()?->can('create', Appointment::class) ?? false);
    }

    public function rules(): array
    {
        $editing = $this->route('appointment') instanceof Appointment;

        return [
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'doctor_id' => ['nullable', 'integer', 'exists:staff,id'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'service_id' => ['nullable', 'integer', 'exists:services,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'duration_minutes' => ['required', 'integer', Rule::in([15, 20, 30, 45, 60])],
            'type' => ['required', 'string', 'max:50'],
            'status' => $editing
                ? ['sometimes', Rule::in(['Pending', 'Confirmed', 'Completed', 'Cancelled', 'No-Show'])]
                : ['required', Rule::in(['Pending', 'Confirmed'])],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
