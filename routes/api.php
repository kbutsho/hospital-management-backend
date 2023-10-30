<?php

use App\Helpers\role;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->group(function () {
    Route::post('/registration', [AuthController::class, 'registration']);
    Route::post('/assistant-registration', [AuthController::class, 'assistantRegistration']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/patient-registration', [PatientController::class, 'createPatient']);

Route::middleware(['jwt.verify', 'role:' . role::DOCTOR])->group(function () {
    Route::post('/create-chamber', [ChamberController::class, 'createChamber']);
});
