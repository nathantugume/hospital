<?php

namespace App\Policies;

use App\Models\TestRequest;
use App\Models\User;

class TestRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist', 'patient',
            'lab_technician', 'pharmacist', 'accountant', 'insurance_officer',
            'inventory_manager', 'hr_manager', 'radiology_technician',
            'physiotherapist', 'surgeon', 'blood_bank_staff',
            'ambulance_dispatcher', 'ambulance_driver']);
    }

    public function view(User $user, TestRequest $record): bool
    {
        if ($user->isPatient()) {
            return $user->patient_id === $record->patient_id;
        }

        return $this->viewAny($user)
            && ($user->isSuperAdmin() || $user->company_id === $record->patient?->company_id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'inventory_manager']);
    }

    public function update(User $user, TestRequest $record): bool
    {
        return $this->view($user, $record)
            && $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
                'lab_technician', 'pharmacist', 'accountant', 'inventory_manager']);
    }

    public function delete(User $user, TestRequest $record): bool
    {
        return $this->view($user, $record) && $user->hasRole(['admin', 'super_admin']);
    }

    public function restore(User $user, TestRequest $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function forceDelete(User $user, TestRequest $record): bool
    {
        return $user->isSuperAdmin();
    }
}
