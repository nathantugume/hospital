<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait ScopesThroughPatientCompany
{
    /**
     * Limit clinical records that inherit tenancy from their patient.
     */
    public function scopeForCompany(Builder $query, User $user): Builder
    {
        if ($user->isPatient()) {
            return $query->where('patient_id', $user->patient_id);
        }

        if ($user->isSuperAdmin()) {
            return $query;
        }

        return $query->whereHas('patient', fn (Builder $patient) => $patient->forCompany($user));
    }
}
