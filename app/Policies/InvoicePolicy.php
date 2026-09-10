<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'accountant', 'receptionist', 'patient', 'insurance_officer']);
    }

    public function view(User $user, Invoice $invoice): bool
    {
        if ($user->isPatient()) {
            return $user->patient_id === $invoice->patient_id;
        }
        return $this->viewAny($user) && ($user->company_id === $invoice->company_id || $user->isSuperAdmin());
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'accountant', 'receptionist']);
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->hasRole(['admin', 'super_admin', 'accountant'])
            && ($user->company_id === $invoice->company_id || $user->isSuperAdmin());
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->isAdmin() && ($user->company_id === $invoice->company_id || $user->isSuperAdmin());
    }

    public function pay(User $user, Invoice $invoice): bool
    {
        return $this->view($user, $invoice);
    }
}
