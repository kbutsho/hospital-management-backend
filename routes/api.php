<?php

use App\Helpers\role;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChamberController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->group(function () {
    Route::post('/registration', [AuthController::class, 'Registration']);
    Route::post('/assistant-registration', [AuthController::class, 'AssistantRegistration']);
    Route::post('/login', [AuthController::class, 'Login']);
});

Route::middleware(['jwt.verify', 'role:' . role::DOCTOR])->group(function () {
    Route::post('/create-chamber', [ChamberController::class, 'CreateChamber']);
});
