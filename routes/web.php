<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\AppointmentController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\InvoiceController;
use App\Http\Controllers\Web\LabController;
use App\Http\Controllers\Web\LegacyPageController;
use App\Http\Controllers\Web\PharmacyController;
use App\Http\Controllers\Web\PatientController;
use App\Http\Controllers\Web\PrescriptionController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SettingsController;
use App\Http\Controllers\Web\StaffController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
    Route::redirect('/login.html', '/login')->name('legacy.login');
    Route::redirect('/register.html', '/register')->name('legacy.register');
    Route::redirect('/forgot-password.html', '/forgot-password')->name('legacy.forgot-password');
    Route::redirect('/two-step-verification.html', '/two-factor-challenge')->name('legacy.two-factor');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::view('/access-denied', 'errors.access-denied')->name('access.denied');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::redirect('/dashboard', '/')->name('dashboard.alias');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:super_admin,admin')
        ->name('admin.dashboard');
    Route::get('/settings', [SettingsController::class, 'edit'])
        ->middleware('role:super_admin,admin')
        ->name('admin.settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])
        ->middleware('role:super_admin,admin')
        ->name('admin.settings.update');
    Route::redirect('/settings.html', '/settings')
        ->middleware('role:super_admin,admin')
        ->name('admin.settings.legacy');

    Route::get('/patients', [PatientController::class, 'index'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.patients.index');
    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->name('web.appointments.index');
    Route::get('/care-team', [StaffController::class, 'index'])
        ->name('web.staff.index');
    Route::get('/laboratory', [LabController::class, 'index'])
        ->name('web.laboratory.index');
    Route::get('/pharmacy', [PharmacyController::class, 'index'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.pharmacy.index');
    Route::get('/pharmacy/alerts', [PharmacyController::class, 'alerts'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.pharmacy.alerts');
    Route::get('/invoices', [InvoiceController::class, 'index'])
        ->middleware('role:super_admin,admin,accountant,insurance_officer')
        ->name('web.invoices.index');
    Route::get('/reports/financial', [ReportController::class, 'financial'])
        ->middleware('role:super_admin,admin,accountant,insurance_officer')
        ->name('web.reports.financial');
    Route::get('/prescriptions/create', [PrescriptionController::class, 'create'])
        ->middleware('role:super_admin,admin,doctor')
        ->name('web.prescriptions.create');
    Route::post('/prescriptions', [PrescriptionController::class, 'store'])
        ->middleware('role:super_admin,admin,doctor')
        ->name('web.prescriptions.store');

    Route::redirect('/index.html', '/')->name('legacy.index');
    Route::get('/{page}.html', [LegacyPageController::class, 'show'])
        ->where('page', '[A-Za-z0-9-]+')
        ->name('legacy.page');
});
