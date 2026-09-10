<?php

namespace App\Http\Requests\Appointments;

use App\Models\AppointmentRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProcessAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $appointmentRequest = $this->route('appointmentRequest');

        return $appointmentRequest instanceof AppointmentRequest
            && ($this->user()?->can('process', $appointmentRequest) ?? false);
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', Rule::in(['Approved', 'Rejected'])],
        ];
    }
}
