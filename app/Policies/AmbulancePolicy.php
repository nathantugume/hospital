<?php

namespace App\Policies;

use App\Models\Ambulance;
use App\Models\User;

class AmbulancePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'insurance_officer',
            'inventory_manager', 'hr_manager', 'radiology_technician',
            'physiotherapist', 'surgeon', 'blood_bank_staff',
            'ambulance_dispatcher', 'ambulance_driver']);
    }

    public function view(User $user, Ambulance $record): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'inventory_manager']);
    }

    public function update(User $user, Ambulance $record): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'inventory_manager']);
    }

    public function delete(User $user, Ambulance $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function restore(User $user, Ambulance $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function forceDelete(User $user, Ambulance $record): bool
    {
        return $user->isSuperAdmin();
    }
}
