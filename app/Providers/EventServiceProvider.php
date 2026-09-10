<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\PatientRegistered;
use App\Events\AbnormalLabResult;
use App\Events\InvoicePaid;
use App\Events\AmbulanceDispatched;
use App\Events\LowStock;
use App\Events\PrescriptionReady;
use App\Events\LabResultReady;
use App\Events\AppointmentReminder;
use App\Listeners\SendWelcomeSms;
use App\Listeners\CreateMedicalRecord;
use App\Listeners\NotifyDoctorOfAbnormalResult;
use App\Listeners\NotifyPatientOfAbnormalResult;
use App\Listeners\UpdateAccountingOnInvoicePaid;
use App\Listeners\SendReceiptSms;
use App\Listeners\NotifyPatientFamilyOnAmbulanceDispatch;
use App\Listeners\UpdateErDashboardOnAmbulanceDispatch;
use App\Listeners\NotifyPharmacyManagerOnLowStock;
use App\Listeners\SendPrescriptionReadySms;
use App\Listeners\SendLabResultReadySms;
use App\Listeners\SendAppointmentReminderSms;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PatientRegistered::class => [
            SendWelcomeSms::class,
            CreateMedicalRecord::class,
        ],
        AbnormalLabResult::class => [
            NotifyDoctorOfAbnormalResult::class,
            NotifyPatientOfAbnormalResult::class,
        ],
        InvoicePaid::class => [
            UpdateAccountingOnInvoicePaid::class,
            SendReceiptSms::class,
        ],
        AmbulanceDispatched::class => [
            NotifyPatientFamilyOnAmbulanceDispatch::class,
            UpdateErDashboardOnAmbulanceDispatch::class,
        ],
        LowStock::class => [
            NotifyPharmacyManagerOnLowStock::class,
        ],
        PrescriptionReady::class => [
            SendPrescriptionReadySms::class,
        ],
        LabResultReady::class => [
            SendLabResultReadySms::class,
        ],
        AppointmentReminder::class => [
            SendAppointmentReminderSms::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
