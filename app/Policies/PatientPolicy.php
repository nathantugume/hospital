<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist', 'lab_technician', 'pharmacist', 'insurance_officer', 'accountant']);
    }

    public function view(User $user, Patient $patient): bool
    {
        // Patients can view their own record
        if ($user->isPatient()) {
            return $user->patient_id === $patient->id;
        }
        // Hospital staff can view patients in their company
        return $this->viewAny($user) && ($user->company_id === $patient->company_id || $user->isSuperAdmin());
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'receptionist', 'doctor', 'nurse']);
    }

    public function update(User $user, Patient $patient): bool
    {
        if ($user->isPatient()) {
            return false; // Patients cannot edit their own medical record (only demographics via profile)
        }
        return $user->hasRole(['admin', 'super_admin', 'receptionist', 'doctor', 'nurse'])
            && ($user->company_id === $patient->company_id || $user->isSuperAdmin());
    }

    public function delete(User $user, Patient $patient): bool
    {
        return $user->isAdmin() && ($user->company_id === $patient->company_id || $user->isSuperAdmin());
    }

    public function restore(User $user, Patient $patient): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Patient $patient): bool
    {
        return $user->isSuperAdmin();
    }

    public function viewMedicalHistory(User $user, Patient $patient): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse'])
            && ($user->company_id === $patient->company_id || $user->isSuperAdmin());
    }
}
