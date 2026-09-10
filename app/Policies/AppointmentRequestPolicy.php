<?php

namespace App\Policies;

use App\Models\AppointmentRequest;
use App\Models\User;

class AppointmentRequestPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist', 'patient']); }
    public function view(User $user, AppointmentRequest $request): bool { return $user->isPatient() ? $user->patient_id === $request->patient_id : $this->viewAny($user) && ($user->isSuperAdmin() || $user->company_id === $request->company_id); }
    public function create(User $user): bool { return $user->isPatient(); }
    public function process(User $user, AppointmentRequest $request): bool { return $this->view($user, $request) && $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist']); }
    public function delete(User $user, AppointmentRequest $request): bool { return $this->view($user, $request) && ($user->isAdmin() || ($user->isPatient() && $request->status === 'Pending')); }
}
