<?php

use App\Helpers\ROLE;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\VisitingHourController;
use Illuminate\Support\Facades\Route;

// Route::middleware(['api'])->group(function () {
//     Route::post('/signup/administrator', [AuthController::class, 'administratorSignup']);
//     Route::post('/signup/doctor', [AuthController::class, 'doctorSignup']);
//     Route::post('/signup/assistant', [AuthController::class, 'assistantSignup']);
//     Route::post('/signup/patient', [AuthController::class, 'patientSignup']);
// });
Route::prefix('signup')->group(function () {
    Route::post('/administrator', [AuthController::class, 'administratorSignup']);
    Route::post('/doctor', [AuthController::class, 'doctorSignup']);
    Route::post('/assistant', [AuthController::class, 'assistantSignup']);
    Route::post('/patient', [AuthController::class, 'patientSignup']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/appointment-registration', [AppointmentController::class, 'createAppointment']);

Route::middleware(['jwt.verify', 'role:' . ROLE::DOCTOR])->group(function () {
    Route::post('/create-chamber', [ChamberController::class, 'createChamber']);
});

Route::middleware(['jwt.verify', 'role:' . ROLE::DOCTOR . '|' . ROLE::ASSISTANT])->group(function () {
    Route::post('/create-schedule', [ScheduleController::class, 'createSchedule']);
    Route::post('/create-visiting-hour', [VisitingHourController::class, 'createVisitingHour']);
});
