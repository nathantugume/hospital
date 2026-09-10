<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ward;

class WardPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole(['admin', 'super_admin', 'doctor', 'nurse', 'receptionist', 'hr_manager']); }
    public function view(User $user, Ward $ward): bool { return $this->viewAny($user) && ($user->isSuperAdmin() || $ward->department?->company_id === $user->company_id); }
    public function create(User $user): bool { return $user->hasRole(['admin', 'super_admin', 'hr_manager']); }
    public function update(User $user, Ward $ward): bool { return $this->view($user, $ward) && $user->hasRole(['admin', 'super_admin', 'hr_manager']); }
    public function delete(User $user, Ward $ward): bool { return $this->view($user, $ward) && $user->hasRole(['admin', 'super_admin']); }
}
