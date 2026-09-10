<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\AppointmentController;
use App\Http\Controllers\Web\AppointmentRequestController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DoctorController;
use App\Http\Controllers\Web\DoctorAvailabilityController;
use App\Http\Controllers\Web\InvoiceController;
use App\Http\Controllers\Web\LabController;
use App\Http\Controllers\Web\LegacyPageController;
use App\Http\Controllers\Web\PharmacyController;
use App\Http\Controllers\Web\PatientController;
use App\Http\Controllers\Web\PrescriptionController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\SettingsController;
use App\Http\Controllers\Web\StaffController;
use App\Http\Controllers\Web\DepartmentController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\WardController;
use App\Http\Controllers\Web\ServiceAvailabilityController;
use App\Http\Controllers\Web\SpecializationController;
use App\Http\Controllers\Web\StaffCertificationController;
use App\Http\Controllers\Web\StaffHrController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\CompanyController;
use App\Http\Controllers\Web\LabCatalogueController;
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
    Route::get('/patients/create', [PatientController::class, 'create'])
        ->middleware('role:super_admin,admin,receptionist,nurse,doctor')
        ->name('web.patients.create');
    Route::post('/patients', [PatientController::class, 'store'])
        ->middleware('role:super_admin,admin,receptionist,nurse,doctor')
        ->name('web.patients.store');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.patients.show');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])
        ->middleware('role:super_admin,admin,receptionist,nurse,doctor')
        ->name('web.patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])
        ->middleware('role:super_admin,admin,receptionist,nurse,doctor')
        ->name('web.patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])
        ->middleware('role:super_admin,admin')
        ->name('web.patients.destroy');
    Route::get('/doctors', [DoctorController::class, 'index'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.doctors.index');
    Route::get('/doctors/create', [DoctorController::class, 'create'])
        ->middleware('role:super_admin,admin')
        ->name('web.doctors.create');
    Route::post('/doctors', [DoctorController::class, 'store'])
        ->middleware('role:super_admin,admin')
        ->name('web.doctors.store');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.doctors.show');
    Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])
        ->middleware('role:super_admin,admin')
        ->name('web.doctors.edit');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])
        ->middleware('role:super_admin,admin')
        ->name('web.doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])
        ->middleware('role:super_admin,admin')
        ->name('web.doctors.destroy');
    Route::get('/doctors/{doctor}/availability', [DoctorAvailabilityController::class, 'index'])
        ->name('web.doctors.availability.index');
    Route::post('/doctors/{doctor}/availability', [DoctorAvailabilityController::class, 'store'])
        ->name('web.doctors.availability.store');
    Route::delete('/doctors/{doctor}/availability/{availability}', [DoctorAvailabilityController::class, 'destroy'])
        ->name('web.doctors.availability.destroy');
    Route::post('/doctors/{doctor}/leave', [DoctorAvailabilityController::class, 'storeLeave'])
        ->name('web.doctors.leave.store');
    Route::patch('/doctors/{doctor}/leave/{leave}', [DoctorAvailabilityController::class, 'updateLeave'])
        ->name('web.doctors.leave.update');
    Route::delete('/doctors/{doctor}/leave/{leave}', [DoctorAvailabilityController::class, 'destroyLeave'])
        ->name('web.doctors.leave.destroy');
    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->name('web.appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])
        ->name('web.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])
        ->name('web.appointments.store');
    Route::get('/appointments/calendar', [AppointmentController::class, 'calendar'])
        ->name('web.appointments.calendar');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])
        ->name('web.appointments.show');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])
        ->name('web.appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])
        ->name('web.appointments.update');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
        ->name('web.appointments.status');
    Route::get('/appointment-requests', [AppointmentRequestController::class, 'index'])->name('web.appointment-requests.index');
    Route::get('/appointment-requests/create', [AppointmentRequestController::class, 'create'])->name('web.appointment-requests.create');
    Route::post('/appointment-requests', [AppointmentRequestController::class, 'store'])->name('web.appointment-requests.store');
    Route::patch('/appointment-requests/{appointmentRequest}', [AppointmentRequestController::class, 'process'])->name('web.appointment-requests.process');
    Route::get('/care-team', [StaffController::class, 'index'])
        ->name('web.staff.index');
    Route::get('/care-team/create', [StaffController::class, 'create'])->name('web.staff.create');
    Route::post('/care-team', [StaffController::class, 'store'])->name('web.staff.store');
    Route::get('/care-team/{staff}', [StaffController::class, 'show'])->name('web.staff.show');
    Route::get('/care-team/{staff}/edit', [StaffController::class, 'edit'])->name('web.staff.edit');
    Route::put('/care-team/{staff}', [StaffController::class, 'update'])->name('web.staff.update');
    Route::delete('/care-team/{staff}', [StaffController::class, 'destroy'])->name('web.staff.destroy');
    Route::post('/care-team/{staff}/certifications', [StaffCertificationController::class, 'store'])->name('web.staff.certifications.store');
    Route::put('/care-team/{staff}/certifications/{certification}', [StaffCertificationController::class, 'update'])->name('web.staff.certifications.update');
    Route::delete('/care-team/{staff}/certifications/{certification}', [StaffCertificationController::class, 'destroy'])->name('web.staff.certifications.destroy');
    Route::get('/care-team/{staff}/hr', [StaffHrController::class, 'show'])->name('web.staff.hr.show');
    Route::post('/care-team/{staff}/attendance', [StaffHrController::class, 'storeAttendance'])->name('web.staff.attendance.store');
    Route::post('/care-team/{staff}/timesheets', [StaffHrController::class, 'storeTimesheet'])->name('web.staff.timesheets.store');
    Route::post('/care-team/{staff}/leave', [StaffHrController::class, 'storeLeave'])->name('web.staff.leave.store');
    Route::patch('/care-team/{staff}/leave/{leave}', [StaffHrController::class, 'updateLeave'])->name('web.staff.leave.update');
    Route::post('/care-team/{staff}/reviews', [StaffHrController::class, 'storeReview'])->name('web.staff.reviews.store');
    Route::resource('departments', DepartmentController::class)->names('web.departments');
    Route::resource('services', ServiceController::class)->names('web.services');
    Route::post('/services/{service}/availability', [ServiceAvailabilityController::class, 'store'])->name('web.services.availability.store');
    Route::delete('/services/{service}/availability/{availability}', [ServiceAvailabilityController::class, 'destroy'])->name('web.services.availability.destroy');
    Route::resource('wards', WardController::class)->names('web.wards');
    Route::resource('specializations', SpecializationController::class)->except('show')->names('web.specializations');
    Route::get('/roles', [RoleController::class, 'index'])->name('web.roles.index');
    Route::patch('/roles/{user}', [RoleController::class, 'update'])->name('web.roles.update');
    Route::resource('companies', CompanyController::class)->except('destroy')->names('web.companies');
    Route::post('/companies/{company}/subscriptions', [CompanyController::class, 'storeSubscription'])->name('web.companies.subscriptions.store');
    Route::patch('/companies/{company}/subscriptions/{subscription}', [CompanyController::class, 'updateSubscription'])->name('web.companies.subscriptions.update');
    Route::get('/laboratory', [LabController::class, 'index'])
        ->name('web.laboratory.index');
    Route::get('/laboratory/requests', [LabController::class, 'requests'])
        ->name('web.laboratory.requests');
    Route::get('/laboratory/requests/create', [LabController::class, 'createRequest'])->name('web.laboratory.requests.create');
    Route::post('/laboratory/requests', [LabController::class, 'storeRequest'])->name('web.laboratory.requests.store');
    Route::get('/laboratory/requests/{testRequest}', [LabController::class, 'showRequest'])->name('web.laboratory.requests.show');
    Route::post('/laboratory/requests/{testRequest}/collect-sample', [LabController::class, 'collectSample'])->name('web.laboratory.requests.collect');
    Route::get('/laboratory/results', [LabController::class, 'results'])->name('web.laboratory.results');
    Route::get('/laboratory/results/{labResult}/edit', [LabController::class, 'editResult'])->name('web.laboratory.results.edit');
    Route::put('/laboratory/results/{labResult}', [LabController::class, 'updateResult'])->name('web.laboratory.results.update');
    Route::patch('/laboratory/results/{labResult}/verify', [LabController::class, 'verifyResult'])->name('web.laboratory.results.verify');
    Route::post('/laboratory/results/{labResult}/attachment', [LabController::class, 'uploadAttachment'])->name('web.laboratory.results.attachment.store');
    Route::get('/laboratory/results/{labResult}/attachment', [LabController::class, 'downloadAttachment'])->name('web.laboratory.results.attachment.download');
    Route::post('/laboratory/results/{labResult}/share', [LabController::class, 'shareResult'])->name('web.laboratory.results.share');
    Route::delete('/laboratory/results/{labResult}/share', [LabController::class, 'revokeShare'])->name('web.laboratory.results.share.revoke');
    Route::get('/laboratory/catalogue', [LabCatalogueController::class,'tests'])->name('web.laboratory.catalogue');
    Route::get('/laboratory/catalogue/create', [LabCatalogueController::class,'createTest'])->name('web.laboratory.catalogue.create');
    Route::post('/laboratory/catalogue', [LabCatalogueController::class,'storeTest'])->name('web.laboratory.catalogue.store');
    Route::get('/laboratory/catalogue/{labTest}/edit', [LabCatalogueController::class,'editTest'])->name('web.laboratory.catalogue.edit');
    Route::put('/laboratory/catalogue/{labTest}', [LabCatalogueController::class,'updateTest'])->name('web.laboratory.catalogue.update');
    Route::delete('/laboratory/catalogue/{labTest}', [LabCatalogueController::class,'destroyTest'])->name('web.laboratory.catalogue.destroy');
    Route::get('/laboratory/equipment', [LabCatalogueController::class,'equipment'])->name('web.laboratory.equipment');
    Route::get('/laboratory/equipment/create', [LabCatalogueController::class,'createEquipment'])->name('web.laboratory.equipment.create');
    Route::post('/laboratory/equipment', [LabCatalogueController::class,'storeEquipment'])->name('web.laboratory.equipment.store');
    Route::get('/laboratory/equipment/{labEquipment}/edit', [LabCatalogueController::class,'editEquipment'])->name('web.laboratory.equipment.edit');
    Route::put('/laboratory/equipment/{labEquipment}', [LabCatalogueController::class,'updateEquipment'])->name('web.laboratory.equipment.update');
    Route::delete('/laboratory/equipment/{labEquipment}', [LabCatalogueController::class,'destroyEquipment'])->name('web.laboratory.equipment.destroy');
    Route::get('/pharmacy', [PharmacyController::class, 'index'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.pharmacy.index');
    Route::get('/pharmacy/alerts', [PharmacyController::class, 'alerts'])
        ->middleware('role:super_admin,admin,doctor,nurse,receptionist,lab_technician,pharmacist,accountant,insurance_officer')
        ->name('web.pharmacy.alerts');
    Route::get('/pharmacy/medicines/create',[PharmacyController::class,'create'])->name('web.pharmacy.create');
    Route::post('/pharmacy/medicines',[PharmacyController::class,'store'])->name('web.pharmacy.store');
    Route::get('/pharmacy/medicines/{medicine}',[PharmacyController::class,'show'])->name('web.pharmacy.show');
    Route::get('/pharmacy/medicines/{medicine}/edit',[PharmacyController::class,'edit'])->name('web.pharmacy.edit');
    Route::put('/pharmacy/medicines/{medicine}',[PharmacyController::class,'update'])->name('web.pharmacy.update');
    Route::delete('/pharmacy/medicines/{medicine}',[PharmacyController::class,'destroy'])->name('web.pharmacy.destroy');
    Route::post('/pharmacy/medicines/{medicine}/batches',[PharmacyController::class,'receiveBatch'])->name('web.pharmacy.batches.store');
    Route::get('/pharmacy/administrations',[PharmacyController::class,'administrations'])->name('web.pharmacy.administrations');
    Route::post('/pharmacy/administrations',[PharmacyController::class,'storeAdministration'])->name('web.pharmacy.administrations.store');
    Route::patch('/pharmacy/administrations/{administration}/administer',[PharmacyController::class,'administer'])->name('web.pharmacy.administrations.administer');
    Route::get('/pharmacy/templates',[PharmacyController::class,'templates'])->name('web.pharmacy.templates');
    Route::post('/pharmacy/templates',[PharmacyController::class,'storeTemplate'])->name('web.pharmacy.templates.store');
    Route::delete('/pharmacy/templates/{medicineTemplate}',[PharmacyController::class,'destroyTemplate'])->name('web.pharmacy.templates.destroy');
    Route::get('/invoices', [InvoiceController::class, 'index'])
        ->middleware('role:super_admin,admin,accountant,insurance_officer')
        ->name('web.invoices.index');
    Route::get('/reports/financial', [ReportController::class, 'financial'])
        ->middleware('role:super_admin,admin,accountant,insurance_officer')
        ->name('web.reports.financial');
    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('web.prescriptions.index');
    Route::get('/prescriptions/create', [PrescriptionController::class, 'create'])
        ->middleware('role:super_admin,admin,doctor')
        ->name('web.prescriptions.create');
    Route::post('/prescriptions', [PrescriptionController::class, 'store'])
        ->middleware('role:super_admin,admin,doctor')
        ->name('web.prescriptions.store');
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class,'show'])->name('web.prescriptions.show');
    Route::get('/prescriptions/{prescription}/edit', [PrescriptionController::class,'edit'])->name('web.prescriptions.edit');
    Route::put('/prescriptions/{prescription}', [PrescriptionController::class,'update'])->name('web.prescriptions.update');
    Route::patch('/prescriptions/{prescription}/discontinue', [PrescriptionController::class,'discontinue'])->name('web.prescriptions.discontinue');
    Route::post('/prescriptions/{prescription}/renew', [PrescriptionController::class,'renew'])->name('web.prescriptions.renew');
    Route::post('/prescriptions/{prescription}/dispense', [PrescriptionController::class,'dispense'])->name('web.prescriptions.dispense');

    Route::redirect('/index.html', '/')->name('legacy.index');
    Route::get('/{page}.html', [LegacyPageController::class, 'show'])
        ->where('page', '[A-Za-z0-9-]+')
        ->name('legacy.page');
});
