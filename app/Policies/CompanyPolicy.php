<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user, Company $record): bool
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Company $record): bool
    {
        return $user->isSuperAdmin();
    }

    public function delete(User $user, Company $record): bool
    {
        return $user->isSuperAdmin();
    }

    public function restore(User $user, Company $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function forceDelete(User $user, Company $record): bool
    {
        return $user->isSuperAdmin();
    }
}
