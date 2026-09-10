<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'day_of_week' => ['nullable', 'integer', 'between:0,6', 'required_without:date'],
            'date' => ['nullable', 'date', 'after_or_equal:today', 'required_without:day_of_week'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'is_available' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function (\Illuminate\Validation\Validator $validator): void {
            if ($this->filled('day_of_week') && $this->filled('date')) {
                $validator->errors()->add('date', 'Choose either a recurring weekday or a specific date, not both.');
            }
        });
    }
}
