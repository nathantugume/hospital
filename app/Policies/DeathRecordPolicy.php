<?php

namespace App\Policies;

use App\Models\DeathRecord;
use App\Models\User;

class DeathRecordPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'insurance_officer',
            'inventory_manager', 'hr_manager', 'radiology_technician',
            'physiotherapist', 'surgeon', 'blood_bank_staff',
            'ambulance_dispatcher', 'ambulance_driver']);
    }

    public function view(User $user, DeathRecord $record): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'inventory_manager']);
    }

    public function update(User $user, DeathRecord $record): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'inventory_manager']);
    }

    public function delete(User $user, DeathRecord $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function restore(User $user, DeathRecord $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function forceDelete(User $user, DeathRecord $record): bool
    {
        return $user->isSuperAdmin();
    }
}
