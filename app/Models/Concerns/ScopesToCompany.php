<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait ScopesToCompany
{
    /**
     * Limit a tenant-owned model to records visible to the given user.
     *
     * Super administrators deliberately retain cross-company access. A user
     * without a company can only see unassigned legacy records; that avoids
     * treating a missing tenant assignment as permission to see every tenant.
     */
    public function scopeForCompany(Builder $query, User $user): Builder
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        $companyId = $user->company_id;

        if ($companyId === null && $user->isPatient()) {
            $companyId = $user->patient?->company_id;
        }

        return $query->where($query->qualifyColumn('company_id'), $companyId);
    }
}
