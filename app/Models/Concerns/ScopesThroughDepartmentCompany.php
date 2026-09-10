<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait ScopesThroughDepartmentCompany
{
    public function scopeForCompany(Builder $query, User $user): Builder
    {
        if ($user->isSuperAdmin()) {
            return $query;
        }

        return $query->whereHas('department', fn (Builder $department) => $department->forCompany($user));
    }
}
