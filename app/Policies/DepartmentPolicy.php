<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\User;

class DepartmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'insurance_officer',
            'inventory_manager', 'hr_manager', 'radiology_technician',
            'physiotherapist', 'surgeon', 'blood_bank_staff',
            'ambulance_dispatcher', 'ambulance_driver']);
    }

    public function view(User $user, Department $record): bool
    {
        return $this->viewAny($user)
            && ($user->isSuperAdmin() || $user->company_id === $record->company_id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'hr_manager']);
    }

    public function update(User $user, Department $record): bool
    {
        return $this->view($user, $record)
            && $user->hasRole(['admin', 'super_admin', 'hr_manager']);
    }

    public function delete(User $user, Department $record): bool
    {
        return $this->view($user, $record) && $user->hasRole(['admin', 'super_admin']);
    }

    public function restore(User $user, Department $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function forceDelete(User $user, Department $record): bool
    {
        return $user->isSuperAdmin();
    }
}
