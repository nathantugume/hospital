<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait ScopesToCompanyOrShared
{
    public function scopeForCompany(Builder $query, User $user): Builder
    {
        if ($user->isSuperAdmin()) { return $query; }
        return $query->where(fn ($q) => $q->where($query->qualifyColumn('company_id'), $user->company_id)->orWhereNull($query->qualifyColumn('company_id')));
    }
}
