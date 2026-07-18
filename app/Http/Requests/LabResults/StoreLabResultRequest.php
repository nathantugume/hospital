<?php

namespace App\Http\Requests\LabResults;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreLabResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'test_name' => 'required|string|max:255',
            'result_value' => 'nullable|string|max:100',
            'normal_range' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'result_date' => 'required|date',
            'status' => 'nullable|in:Normal,Abnormal,Critical,Pending',
            'flag' => 'nullable|in:Normal,High,Low,Critical'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'email' => 'Please enter a valid email address.',
            'unique' => 'This :attribute is already in use.',
            'exists' => 'The selected :attribute does not exist.',
            'date' => 'Please enter a valid date.',
            'numeric' => 'The :attribute must be a number.',
            'integer' => 'The :attribute must be a whole number.',
            'min' => 'The :attribute must be at least :min.',
            'max' => 'The :attribute may not be greater than :max.',
            'in' => 'The selected :attribute is invalid.',
            'after' => 'The :attribute must be a date after :date.',
            'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
            'date_format' => 'The :attribute does not match the format :format.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
