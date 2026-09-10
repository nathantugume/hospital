<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\TwoFactorController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AppointmentRequestController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\InsuranceClaimController;
use App\Http\Controllers\Api\InsuranceProviderController;
use App\Http\Controllers\Api\LabTestController;
use App\Http\Controllers\Api\LabResultController;
use App\Http\Controllers\Api\TestRequestController;
use App\Http\Controllers\Api\LabEquipmentController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\InventoryItemController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\InventoryTransferController;
use App\Http\Controllers\Api\RadiologyOrderController;
use App\Http\Controllers\Api\SurgeryController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\RoomAllotmentController;
use App\Http\Controllers\Api\BloodDonorController;
use App\Http\Controllers\Api\BloodUnitController;
use App\Http\Controllers\Api\BloodIssueController;
use App\Http\Controllers\Api\AmbulanceController;
use App\Http\Controllers\Api\AmbulanceCallController;
use App\Http\Controllers\Api\BirthRecordController;
use App\Http\Controllers\Api\DeathRecordController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PayrollController;
use App\Http\Controllers\Api\PayslipController;
use App\Http\Controllers\Api\PhysiotherapySessionController;
use App\Http\Controllers\Api\VaccinationController;
use App\Http\Controllers\Api\CalendarEventController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\GdprController;
use App\Http\Controllers\Api\Integrations\AfricasTalkingController;
use App\Http\Controllers\Api\Integrations\MobileMoneyController;
use App\Http\Controllers\Api\Integrations\InsuranceIntegrationController;
use App\Http\Controllers\Api\Integrations\NationalIdController;
use App\Http\Controllers\Api\Integrations\LisController;
use App\Http\Controllers\Api\Integrations\AmbulanceGpsController;
use App\Http\Controllers\Api\Integrations\TwilioController;
use App\Http\Controllers\Api\Integrations\PharmacySupplyChainController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Meditrack HMS
|--------------------------------------------------------------------------
| All routes prefixed with /api/v1
| Auth routes use Sanctum tokens + rate limiting.
*/

Route::prefix('v1')->group(function () {

    // ============================================================
    // Health check (public)
    // ============================================================
    Route::get('/health', [HealthController::class, 'index']);

    // ============================================================
    // Auth (public — rate-limited)
    // ============================================================
    Route::middleware(['throttle:login'])->group(function () {
        Route::post('/auth/login', [AuthController::class, 'login']);
    });
    Route::middleware(['throttle:register'])->group(function () {
        Route::post('/auth/register', [AuthController::class, 'register']);
    });
    Route::middleware(['throttle:password-reset'])->group(function () {
        Route::post('/auth/forgot-password', [PasswordResetController::class, 'sendResetLink']);
        Route::post('/auth/reset-password', [PasswordResetController::class, 'reset']);
    });

    // Email verification (uses signed URLs)
    Route::get('/auth/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])->name('api.verification.verify');
    Route::post('/auth/email/resend', [EmailVerificationController::class, 'resend'])
        ->middleware(['auth:sanctum', 'throttle:3,1']);

    // Two-factor challenge
    Route::middleware(['throttle:2fa'])->group(function () {
        Route::post('/auth/2fa-challenge', [TwoFactorController::class, 'challenge']);
    });

    // ============================================================
    // Protected routes (auth:sanctum + throttle:60,1)
    // All authenticated API requests are rate-limited to 60/min per user
    // to prevent abuse and data scraping.
    // ============================================================
    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {

        // Auth / self
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        Route::get('/auth/2fa/qr', [TwoFactorController::class, 'qr']);
        Route::post('/auth/2fa/enable', [TwoFactorController::class, 'enable']);
        Route::post('/auth/2fa/disable', [TwoFactorController::class, 'disable']);
        Route::post('/auth/2fa/recovery-codes', [TwoFactorController::class, 'regenerateRecoveryCodes']);

        // Password confirmation (for sensitive actions)
        Route::post('/auth/confirm-password', function (Request $request) {
            $request->validate(['password' => 'required|string']);
            if (! \Illuminate\Support\Facades\Hash::check($request->password, $request->user()->password)) {
                return response()->json(['success' => false, 'message' => 'Invalid password.'], 422);
            }
            $request->session()->passwordConfirmed();
            return response()->json(['success' => true, 'message' => 'Password confirmed.']);
        });

        // ============================================================
        // Patients
        // ============================================================
        Route::apiResource('patients', PatientController::class);
        Route::get('patients/{patient}/appointments', [PatientController::class, 'appointments']);
        Route::get('patients/{patient}/lab-results', [PatientController::class, 'labResults']);
        Route::get('patients/{patient}/prescriptions', [PatientController::class, 'prescriptions']);
        Route::get('patients/{patient}/invoices', [PatientController::class, 'invoices']);
        Route::post('patients/{patient}/verify-national-id', [NationalIdController::class, 'verifyPatient']);

        // ============================================================
        // Staff / Doctors / Departments
        // ============================================================
        Route::apiResource('staff', StaffController::class);
        Route::apiResource('doctors', DoctorController::class);
        Route::apiResource('departments', DepartmentController::class);
        Route::get('departments/{department}/staff', [DepartmentController::class, 'staff']);
        Route::get('departments/{department}/rooms', [DepartmentController::class, 'rooms']);

        // ============================================================
        // Appointments
        // ============================================================
        Route::apiResource('appointments', AppointmentController::class);
        Route::post('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm']);
        Route::post('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel']);
        Route::post('appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule']);
        Route::get('appointments/calendar/events', [AppointmentController::class, 'calendarEvents']);
        Route::apiResource('appointment-requests', AppointmentRequestController::class)->only(['index', 'store', 'update', 'destroy']);

        // ============================================================
        // Billing / Invoices
        // ============================================================
        Route::apiResource('invoices', InvoiceController::class);
        Route::post('invoices/{invoice}/pay', [InvoiceController::class, 'pay']);
        Route::post('invoices/{invoice}/cancel', [InvoiceController::class, 'cancel']);
        Route::get('invoices/{invoice}/receipt', [InvoiceController::class, 'receipt']);
        Route::apiResource('invoices.items', InvoiceController::class)->shallow()->only(['index']);

        // ============================================================
        // Insurance
        // ============================================================
        Route::apiResource('insurance-providers', InsuranceProviderController::class)->only(['index', 'show']);
        Route::apiResource('insurance-claims', InsuranceClaimController::class);
        Route::post('insurance-claims/{claim}/submit', [InsuranceClaimController::class, 'submit']);
        Route::post('insurance-claims/{claim}/pre-authorize', [InsuranceClaimController::class, 'preAuthorize']);
        Route::get('insurance-claims/{claim}/communications', [InsuranceClaimController::class, 'communications']);

        // ============================================================
        // Lab
        // ============================================================
        Route::apiResource('lab-tests', LabTestController::class)->only(['index', 'show']);
        Route::apiResource('test-requests', TestRequestController::class);
        Route::post('test-requests/{testRequest}/collect-sample', [TestRequestController::class, 'collectSample']);
        Route::apiResource('lab-results', LabResultController::class);
        Route::post('lab-results/{labResult}/verify', [LabResultController::class, 'verify']);
        Route::get('lab-results/{labResult}/share', [LabResultController::class, 'shareUrl']);
        Route::apiResource('lab-equipment', LabEquipmentController::class);

        // ============================================================
        // Pharmacy
        // ============================================================
        Route::apiResource('medicines', MedicineController::class);
        Route::get('medicines/{medicine}/transactions', [MedicineController::class, 'transactions']);
        Route::get('medicines/{medicine}/batches', [MedicineController::class, 'batches']);
        Route::apiResource('prescriptions', PrescriptionController::class);
        Route::post('prescriptions/{prescription}/dispense', [PrescriptionController::class, 'dispense']);
        Route::post('prescriptions/{prescription}/renew', [PrescriptionController::class, 'renew']);

        // ============================================================
        // Inventory / Suppliers / Transfers
        // ============================================================
        Route::apiResource('inventory-items', InventoryItemController::class);
        Route::apiResource('suppliers', SupplierController::class);
        Route::apiResource('purchase-orders', PurchaseOrderController::class);
        Route::apiResource('inventory-transfers', InventoryTransferController::class);
        Route::post('inventory-transfers/{transfer}/approve', [InventoryTransferController::class, 'approve']);
        Route::post('inventory-transfers/{transfer}/dispatch', [InventoryTransferController::class, 'dispatch']);
        Route::post('inventory-transfers/{transfer}/receive', [InventoryTransferController::class, 'receive']);
        Route::get('stock-alerts', [InventoryItemController::class, 'stockAlerts']);

        // ============================================================
        // Radiology / Surgery / Rooms
        // ============================================================
        Route::apiResource('radiology-orders', RadiologyOrderController::class);
        Route::apiResource('surgeries', SurgeryController::class);
        Route::apiResource('rooms', RoomController::class);
        Route::apiResource('room-allotments', RoomAllotmentController::class);

        // ============================================================
        // Blood Bank
        // ============================================================
        Route::apiResource('blood-donors', BloodDonorController::class);
        Route::apiResource('blood-units', BloodUnitController::class);
        Route::apiResource('blood-issues', BloodIssueController::class);

        // ============================================================
        // Ambulance
        // ============================================================
        Route::apiResource('ambulances', AmbulanceController::class);
        Route::apiResource('ambulance-calls', AmbulanceCallController::class);
        Route::post('ambulance-calls/{call}/dispatch', [AmbulanceCallController::class, 'dispatch']);
        Route::post('ambulance-calls/{call}/arrive', [AmbulanceCallController::class, 'arrive']);
        Route::post('ambulance-calls/{call}/complete', [AmbulanceCallController::class, 'complete']);
        Route::get('ambulances/{ambulance}/track', [AmbulanceController::class, 'track']);

        // ============================================================
        // Birth / Death
        // ============================================================
        Route::apiResource('birth-records', BirthRecordController::class);
        Route::apiResource('death-records', DeathRecordController::class);
        Route::get('birth-records/{birthRecord}/certificate', [BirthRecordController::class, 'certificate']);
        Route::get('death-records/{deathRecord}/certificate', [DeathRecordController::class, 'certificate']);

        // ============================================================
        // Services / Payroll / Physiotherapy / Vaccinations
        // ============================================================
        Route::apiResource('services', ServiceController::class);
        Route::apiResource('payroll', PayrollController::class);
        Route::apiResource('payslips', PayslipController::class);
        Route::apiResource('physiotherapy-sessions', PhysiotherapySessionController::class);
        Route::apiResource('vaccinations', VaccinationController::class);

        // ============================================================
        // Communication
        // ============================================================
        Route::apiResource('calendar-events', CalendarEventController::class);
        Route::apiResource('notifications', NotificationController::class)->only(['index', 'update', 'destroy']);
        Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead']);
        Route::get('chat/threads', [ChatController::class, 'threads']);
        Route::get('chat/threads/{thread}/messages', [ChatController::class, 'messages']);
        Route::post('chat/threads/{thread}/messages', [ChatController::class, 'sendMessage']);

        // ============================================================
        // Audit log (super_admin / admin only)
        // ============================================================
        Route::middleware(RoleMiddleware::class . ':super_admin,admin')->group(function () {
            Route::get('audit-logs', [AuditLogController::class, 'index']);
        });

        // ============================================================
        // GDPR / DPPA Compliance Endpoints (Right to Access, Erasure, Consent)
        // ============================================================
        Route::prefix('patients/{patient}')->group(function () {
            Route::get('data-export', [GdprController::class, 'exportPatientData']);
            Route::delete('erase', [GdprController::class, 'erasePatientData']);
            Route::get('consents', [GdprController::class, 'listConsents']);
            Route::post('consents', [GdprController::class, 'updateConsent']);
        });

        // Public compliance endpoints (no auth for privacy policy)
        Route::get('/privacy-policy', [GdprController::class, 'privacyPolicy']);
        Route::get('/data-retention-policy', [GdprController::class, 'retentionPolicy']);

        // ============================================================
        // File Uploads (patient photos, lab reports, DICOM, documents)
        // ============================================================
        Route::prefix('uploads')->group(function () {
            Route::get('/categories', [FileUploadController::class, 'categories']);
            Route::post('/', [FileUploadController::class, 'upload']);
            Route::post('/multiple', [FileUploadController::class, 'uploadMultiple']);
            Route::get('/{path}', [FileUploadController::class, 'download'])->where('path', '.*');
            Route::delete('/{path}', [FileUploadController::class, 'destroy'])->where('path', '.*');
        });

        // ============================================================
        // Audit Logs — enhanced with stats + export
        // ============================================================
        Route::middleware(RoleMiddleware::class . ':super_admin,admin')->prefix('audit-logs')->group(function () {
            Route::get('/', [AuditLogController::class, 'index']);
            Route::get('/export', [AuditLogController::class, 'export']);
            Route::get('/stats', [AuditLogController::class, 'stats']);
        });

        // ============================================================
        // Backup Management (super_admin only)
        // ============================================================
        Route::middleware(RoleMiddleware::class . ':super_admin')->prefix('backups')->group(function () {
            Route::get('/', function () {
                $backups = collect(glob(storage_path('app/meditrack-backup/*.zip')))
                    ->map(function ($file) {
                        return [
                            'filename' => basename($file),
                            'size' => filesize($file),
                            'size_human' => round(filesize($file) / 1024 / 1024, 1) . ' MB',
                            'created_at' => date('Y-m-d H:i:s', filemtime($file)),
                        ];
                    })->sortByDesc('created_at')->values();
                return response()->json(['success' => true, 'data' => $backups]);
            });
            Route::post('/run', function (\Illuminate\Http\Request $request) {
                \Illuminate\Support\Facades\Artisan::call('backup:run');
                return response()->json(['success' => true, 'message' => 'Backup started.']);
            });
            Route::post('/clean', function (\Illuminate\Http\Request $request) {
                \Illuminate\Support\Facades\Artisan::call('backup:clean');
                return response()->json(['success' => true, 'message' => 'Old backups cleaned.']);
            });
            Route::get('/status', function () {
                $health = \Spatie\Backup\BackupDestination\BackupDestination::create('local', 'meditrack-backup');
                return response()->json([
                    'success' => true,
                    'data' => [
                        'healthy' => $health->isHealthy(),
                        'total_backups' => $health->backups()->count(),
                        'newest_backup' => $health->newestBackup()?->date()->toIso8601String(),
                        'used_storage' => round($health->backups()->size() / 1024 / 1024, 1) . ' MB',
                    ],
                ]);
            });
        });

        // ============================================================
        // File Uploads (patient photos, lab reports, DICOM, documents)
        // ============================================================
        Route::post('/uploads', [\App\Http\Controllers\Api\FileUploadController::class, 'upload']);
        Route::delete('/uploads/{path}', [\App\Http\Controllers\Api\FileUploadController::class, 'delete'])
            ->where('path', '.*');

        // ============================================================
        // ============================================================
        // Backup Management (admin only)
        // ============================================================
        Route::middleware(RoleMiddleware::class . ":super_admin,admin")->prefix("admin/backup")->group(function () {
            Route::get("status", [\App\Http\Controllers\Api\BackupController::class, "status"]);
            Route::post("run", [\App\Http\Controllers\Api\BackupController::class, "run"]);
            Route::post("clean", [\App\Http\Controllers\Api\BackupController::class, "clean"]);
        });

        // Super-admin only: Companies / Subscriptions / Roles
        // ============================================================
        Route::middleware(RoleMiddleware::class . ':super_admin')->group(function () {
            Route::apiResource('companies', CompanyController::class);
            Route::apiResource('subscriptions', SubscriptionController::class);
        });

        // ============================================================
        // Integration endpoints (role-restricted)
        // ============================================================
        Route::middleware(RoleMiddleware::class . ':admin,super_admin,receptionist,doctor,nurse,pharmacist,accountant,insurance_officer,ambulance_dispatcher,lab_technician')->prefix('integrations')->group(function () {
            // SMS / Africa's Talking
            Route::post('sms/send', [AfricasTalkingController::class, 'send']);
            Route::get('sms/logs', [AfricasTalkingController::class, 'logs']);

            // Mobile Money
            Route::post('payments/mtn/initiate', [MobileMoneyController::class, 'initiateMtn']);
            Route::post('payments/airtel/initiate', [MobileMoneyController::class, 'initiateAirtel']);
            Route::post('payments/mpesa/initiate', [MobileMoneyController::class, 'initiateMpesa']);
            Route::get('payments/{transaction}/status', [MobileMoneyController::class, 'status']);
            Route::get('payments/logs', [MobileMoneyController::class, 'logs']);

            // Insurance API
            Route::post('insurance/{provider}/verify-policy', [InsuranceIntegrationController::class, 'verifyPolicy']);
            Route::post('insurance/{provider}/pre-authorize', [InsuranceIntegrationController::class, 'preAuthorize']);
            Route::post('insurance/{provider}/submit-claim', [InsuranceIntegrationController::class, 'submitClaim']);

            // National ID verification
            Route::post('national-id/verify', [NationalIdController::class, 'verify']);

            // LIS
            Route::post('lis/push-result', [LisController::class, 'pushResult']);
            Route::get('lis/equipment/{equipment}/status', [LisController::class, 'equipmentStatus']);

            // GPS Tracking
            Route::post('gps/update', [AmbulanceGpsController::class, 'updatePosition']);
            Route::get('gps/{ambulance}/latest', [AmbulanceGpsController::class, 'latestPosition']);

            // Twilio emergency
            Route::post('twilio/emergency-call', [TwilioController::class, 'emergencyCall']);
            Route::post('twilio/triage', [TwilioController::class, 'triage']);

            // Pharmacy supply chain
            Route::post('nms/order', [PharmacySupplyChainController::class, 'placeOrderApi']);
            Route::post('kemsa/order', [PharmacySupplyChainController::class, 'placeOrderApi']);
        });
    });

    // ============================================================
    // File download (public — uses signed token for access)
    // ============================================================
    Route::get('/uploads/{path}', [\App\Http\Controllers\Api\FileUploadController::class, 'download'])
        ->where('path', '.*')
        ->withoutMiddleware(['auth:sanctum', 'throttle:60,1']);

    // ============================================================
    // Public Webhooks (CSRF-excluded in VerifyCsrfToken)
    // ============================================================
    Route::post('/payments/mtn/callback', [MobileMoneyController::class, 'mtnCallback']);
    Route::post('/payments/airtel/callback', [MobileMoneyController::class, 'airtelCallback']);
    Route::post('/payments/mpesa/callback', [MobileMoneyController::class, 'mpesaCallback']);
    Route::post('/integrations/africas-talking/callback', [AfricasTalkingController::class, 'callback']);
    Route::post('/integrations/lis/webhook', [LisController::class, 'webhook']);
    Route::post('/integrations/gps/callback', [AmbulanceGpsController::class, 'callback']);

    // Patient portal share URL (signed)
    Route::get('/share/lab-result/{token}', [LabResultController::class, 'sharedView'])
        ->name('share.lab-result');

});

// Fallback for unknown /api routes
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint not found.',
    ], 404);
});
