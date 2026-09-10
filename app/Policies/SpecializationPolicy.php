<?php

namespace App\Policies;

use App\Models\Specialization;
use App\Models\User;

class SpecializationPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist', 'hr_manager']); }
    public function view(User $user, Specialization $specialization): bool { return $this->viewAny($user) && ($user->isSuperAdmin() || $user->company_id === $specialization->company_id); }
    public function create(User $user): bool { return $user->hasRole(['admin', 'super_admin', 'hr_manager']); }
    public function update(User $user, Specialization $specialization): bool { return $this->view($user, $specialization) && $this->create($user); }
    public function delete(User $user, Specialization $specialization): bool { return $this->view($user, $specialization) && $user->hasRole(['admin', 'super_admin']); }
}
