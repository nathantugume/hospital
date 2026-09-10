<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'role_label' => $this->role_label,
            'company_id' => $this->company_id,
            'staff_id' => $this->staff_id,
            'patient_id' => $this->patient_id,
            'avatar' => $this->avatar,
            'preferred_language' => $this->preferred_language,
            'preferred_currency' => $this->preferred_currency,
            'timezone' => $this->timezone,
            'email_verified_at' => $this->email_verified_at,
            'two_factor_enabled' => ! is_null($this->two_factor_confirmed_at),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
