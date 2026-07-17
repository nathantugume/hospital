<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index']);

Route::get('/home',[HomeController::class,'redirect']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/add_doctor_view',[AdminController::class,'addview']);
Route::post('/add_doctor',[AdminController::class,'add_doctor']);
Route::post('/add_appointment',[AppointmentController::class,'store']);
Route::get('/view_appointments',[AppointmentController::class,'index']);
Route::get('/myappointment',[AppointmentController::class,'myappointment']);
Route::get('/cancel_appointment/{id}',[AppointmentController::class,'cancel_appointment']);
Route::get('/emailview/{id}',[AppointmentController::class,'emailview']);
Route::post('/sendemail/{id}',[AppointmentController::class,'sendemail']);
