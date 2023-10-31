<?php

use App\Helpers\ROLE;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\VisitingHourController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->group(function () {
    Route::post('/registration', [AuthController::class, 'registration']);
    Route::post('/assistant-registration', [AuthController::class, 'assistantRegistration']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/patient-registration', [PatientController::class, 'createPatient']);
Route::post('/appointment-registration', [AppointmentController::class, 'createAppointment']);

Route::middleware(['jwt.verify', 'role:' . ROLE::DOCTOR])->group(function () {
    Route::post('/create-chamber', [ChamberController::class, 'createChamber']);
});

Route::middleware(['jwt.verify', 'role:' . ROLE::DOCTOR . '|' . ROLE::ASSISTANT])->group(function () {
    Route::post('/create-schedule', [ScheduleController::class, 'createSchedule']);
    Route::post('/create-visiting-hour', [VisitingHourController::class, 'createVisitingHour']);
});
