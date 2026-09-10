<?php

namespace App\Http\Requests\Medicines;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMedicineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'selling_price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:In Stock,Low Stock,Out of Stock'
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
