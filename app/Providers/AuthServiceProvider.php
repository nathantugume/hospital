<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Patient::class => \App\Policies\PatientPolicy::class,
        \App\Models\Staff::class => \App\Policies\StaffPolicy::class,
        \App\Models\Appointment::class => \App\Policies\AppointmentPolicy::class,
        \App\Models\Invoice::class => \App\Policies\InvoicePolicy::class,
        \App\Models\InsuranceClaim::class => \App\Policies\InsuranceClaimPolicy::class,
        \App\Models\LabResult::class => \App\Policies\LabResultPolicy::class,
        \App\Models\Prescription::class => \App\Policies\PrescriptionPolicy::class,
        \App\Models\Medicine::class => \App\Policies\MedicinePolicy::class,
        \App\Models\RadiologyOrder::class => \App\Policies\RadiologyOrderPolicy::class,
        \App\Models\Surgery::class => \App\Policies\SurgeryPolicy::class,
        \App\Models\Ambulance::class => \App\Policies\AmbulancePolicy::class,
        \App\Models\AmbulanceCall::class => \App\Policies\AmbulanceCallPolicy::class,
        \App\Models\BloodUnit::class => \App\Policies\BloodUnitPolicy::class,
        \App\Models\BirthRecord::class => \App\Policies\BirthRecordPolicy::class,
        \App\Models\DeathRecord::class => \App\Policies\DeathRecordPolicy::class,
        \App\Models\InventoryItem::class => \App\Policies\InventoryItemPolicy::class,
        \App\Models\Supplier::class => \App\Policies\SupplierPolicy::class,
        \App\Models\PayrollEntry::class => \App\Policies\PayrollEntryPolicy::class,
        \App\Models\Room::class => \App\Policies\RoomPolicy::class,
        \App\Models\Company::class => \App\Policies\CompanyPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // ============================================================
        // Role-based Gates
        // ============================================================
        Gate::define('is-super-admin', fn($user) => $user->isSuperAdmin());
        Gate::define('is-admin', fn($user) => $user->isAdmin());
        Gate::define('is-doctor', fn($user) => $user->isDoctor());
        Gate::define('is-nurse', fn($user) => $user->isNurse());
        Gate::define('is-receptionist', fn($user) => $user->isReceptionist());
        Gate::define('is-lab-tech', fn($user) => $user->isLabTech());
        Gate::define('is-pharmacist', fn($user) => $user->isPharmacist());
        Gate::define('is-patient', fn($user) => $user->isPatient());
        Gate::define('is-accountant', fn($user) => $user->isAccountant());
        Gate::define('is-insurance-officer', fn($user) => $user->isInsuranceOfficer());
        Gate::define('is-hr-manager', fn($user) => $user->isHrManager());
        Gate::define('is-inventory-manager', fn($user) => $user->isInventoryManager());
        Gate::define('is-ambulance-dispatcher', fn($user) => $user->isAmbulanceDispatcher());
        Gate::define('is-ambulance-driver', fn($user) => $user->isAmbulanceDriver());

        // Combined gates
        Gate::define('manage-patients', fn($user) => $user->hasRole(['admin', 'super_admin', 'receptionist', 'doctor', 'nurse']));
        Gate::define('manage-staff', fn($user) => $user->hasRole(['admin', 'super_admin', 'hr_manager']));
        Gate::define('manage-billing', fn($user) => $user->hasRole(['admin', 'super_admin', 'accountant', 'receptionist']));
        Gate::define('manage-insurance', fn($user) => $user->hasRole(['admin', 'super_admin', 'insurance_officer', 'accountant']));
        Gate::define('manage-lab', fn($user) => $user->hasRole(['admin', 'super_admin', 'lab_technician', 'doctor', 'nurse']));
        Gate::define('manage-pharmacy', fn($user) => $user->hasRole(['admin', 'super_admin', 'pharmacist', 'doctor']));
        Gate::define('manage-radiology', fn($user) => $user->hasRole(['admin', 'super_admin', 'radiology_technician', 'doctor']));
        Gate::define('manage-surgery', fn($user) => $user->hasRole(['admin', 'super_admin', 'surgeon', 'doctor']));
        Gate::define('manage-blood-bank', fn($user) => $user->hasRole(['admin', 'super_admin', 'blood_bank_staff', 'nurse']));
        Gate::define('manage-ambulance', fn($user) => $user->hasRole(['admin', 'super_admin', 'ambulance_dispatcher', 'ambulance_driver', 'receptionist']));
        Gate::define('manage-inventory', fn($user) => $user->hasRole(['admin', 'super_admin', 'inventory_manager', 'pharmacist']));
        Gate::define('manage-payroll', fn($user) => $user->hasRole(['admin', 'super_admin', 'accountant', 'hr_manager']));
        Gate::define('manage-rooms', fn($user) => $user->hasRole(['admin', 'super_admin', 'nurse', 'receptionist']));
        Gate::define('manage-physiotherapy', fn($user) => $user->hasRole(['admin', 'super_admin', 'physiotherapist', 'doctor']));
        Gate::define('manage-vaccinations', fn($user) => $user->hasRole(['admin', 'super_admin', 'nurse']));
        Gate::define('manage-records', fn($user) => $user->hasRole(['admin', 'super_admin', 'receptionist']));
        Gate::define('manage-super-admin', fn($user) => $user->isSuperAdmin());
        Gate::define('view-reports', fn($user) => $user->hasRole(['admin', 'super_admin', 'accountant', 'hr_manager']));
    }
}
