<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\InvoiceController;
use App\Http\Controllers\Web\LegacyPageController;
use App\Http\Controllers\Web\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::view('/access-denied', 'errors.access-denied')->name('access.denied');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::redirect('/dashboard', '/')->name('dashboard.alias');

    Route::get('/patients', [PatientController::class, 'index'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.patients.index');
    Route::get('/invoices', [InvoiceController::class, 'index'])
        ->middleware('role:super_admin,admin,accountant,insurance_officer')
        ->name('web.invoices.index');

    Route::redirect('/index.html', '/')->name('legacy.index');
    Route::redirect('/login.html', '/login')->name('legacy.login');
    Route::get('/{page}.html', [LegacyPageController::class, 'show'])
        ->where('page', '[A-Za-z0-9-]+')
        ->name('legacy.page');
});
