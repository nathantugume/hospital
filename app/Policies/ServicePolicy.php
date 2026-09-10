<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'insurance_officer',
            'inventory_manager', 'hr_manager', 'radiology_technician',
            'physiotherapist', 'surgeon', 'blood_bank_staff',
            'ambulance_dispatcher', 'ambulance_driver']);
    }

    public function view(User $user, Service $record): bool
    {
        return $this->viewAny($user)
            && ($user->isSuperAdmin() || $record->department?->company_id === $user->company_id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'hr_manager']);
    }

    public function update(User $user, Service $record): bool
    {
        return $this->view($user, $record) && $user->hasRole(['admin', 'super_admin', 'hr_manager']);
    }

    public function delete(User $user, Service $record): bool
    {
        return $this->view($user, $record) && $user->hasRole(['admin', 'super_admin', 'hr_manager']);
    }

    public function restore(User $user, Service $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function forceDelete(User $user, Service $record): bool
    {
        return $user->isSuperAdmin();
    }
}
