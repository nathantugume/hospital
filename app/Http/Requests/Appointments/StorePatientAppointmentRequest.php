<?php

namespace App\Http\Requests\Appointments;

use App\Models\AppointmentRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePatientAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', AppointmentRequest::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => ['nullable', 'integer', 'exists:staff,id'],
            'requested_date' => ['required', 'date', 'after_or_equal:today'],
            'requested_time' => ['required', 'date_format:H:i'],
            'type' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
