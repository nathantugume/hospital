<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist', 'patient',
            'lab_technician', 'pharmacist', 'accountant', 'insurance_officer',
            'inventory_manager', 'hr_manager', 'radiology_technician',
            'physiotherapist', 'surgeon', 'blood_bank_staff',
            'ambulance_dispatcher', 'ambulance_driver']);
    }

    public function view(User $user, Appointment $record): bool
    {
        if ($user->isPatient()) {
            return $user->patient_id === $record->patient_id;
        }
        if ($user->isDoctor()) {
            return $user->staff_id === $record->doctor_id;
        }

        return $this->viewAny($user)
            && ($user->isSuperAdmin() || $user->company_id === $record->company_id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
            'lab_technician', 'pharmacist', 'accountant', 'inventory_manager']);
    }

    public function update(User $user, Appointment $record): bool
    {
        return $this->view($user, $record)
            && $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist',
                'lab_technician', 'pharmacist', 'accountant', 'inventory_manager']);
    }

    public function delete(User $user, Appointment $record): bool
    {
        return $this->view($user, $record) && $user->hasRole(['admin', 'super_admin']);
    }

    public function restore(User $user, Appointment $record): bool
    {
        return $user->hasRole(['admin', 'super_admin']);
    }

    public function forceDelete(User $user, Appointment $record): bool
    {
        return $user->isSuperAdmin();
    }
}
