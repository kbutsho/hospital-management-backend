<?php

use App\Helpers\ROLE;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VisitingHourController;
use Illuminate\Support\Facades\Route;

Route::prefix('signup')->group(function () {
    Route::post('/administrator', [AuthController::class, 'administratorSignup']);
    Route::post('/doctor', [AuthController::class, 'doctorSignup']);
    Route::post('/assistant', [AuthController::class, 'assistantSignup']);
    Route::post('/patient', [AuthController::class, 'patientSignup']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/appointment-registration', [AppointmentController::class, 'createAppointment']);
Route::get('/department/all', [DepartmentController::class, 'getAllDepartment']);
Route::get('/doctor/all', [DoctorController::class, 'getAllDoctorList']);
Route::get('/doctor-with-chamber/all', [DoctorController::class, 'getDoctorListWithChambers']);

Route::prefix('doctor')->group(function () {
    Route::middleware(['jwt.verify', 'role:' . ROLE::DOCTOR])->group(function () {
        Route::post('/chamber/create', [ChamberController::class, 'createChamber']);
        Route::get('/chamber/all', [ChamberController::class, 'getDoctorsChamber']);
        Route::delete('/chamber/{id}', [ChamberController::class, 'deleteChamber']);
        Route::patch('/chamber/{id}', [ChamberController::class, 'updateChamber']);
    });
});

Route::middleware(['jwt.verify', 'role:' . ROLE::DOCTOR . '|' . ROLE::ASSISTANT])->group(function () {
    Route::post('/create-schedule', [ScheduleController::class, 'createSchedule']);
    Route::post('/create-visiting-hour', [VisitingHourController::class, 'createVisitingHour']);
});

Route::prefix('administrator')->group(function () {
    Route::middleware(['jwt.verify', 'role:' . ROLE::ADMINISTRATOR])->group(function () {
        Route::get('/doctor/all', [DoctorController::class, 'getDoctorWithDepartment']);
        Route::post('/doctor/update/status', [DoctorController::class, 'updateDoctorStatus']);
        Route::delete('/doctor/{id}', [DoctorController::class, 'deleteDoctor']);


        Route::get('/assistant/all', [AssistantController::class, 'getAllAssistant']);
        Route::post('/doctor/update/status', [DoctorController::class, 'updateDoctorStatus']);
        Route::delete('/doctor/{id}', [DoctorController::class, 'deleteDoctor']);

        Route::post('/department/create', [DepartmentController::class, 'createDepartment']);
        Route::get('/department/all', [DepartmentController::class, 'getAllDepartment']);
        Route::delete('/department/{id}', [DepartmentController::class, 'deleteDepartment']);
        Route::patch('/department/{id}', [DepartmentController::class, 'updateDepartment']);
    });
});

Route::post('/test/add', [TestController::class, 'create']);
Route::get('/test/all', [TestController::class, 'get']);
Route::get('/test', [TestController::class, 'getAll']);
Route::patch('/test/{id}', [TestController::class, 'update']);
Route::delete('/test/{id}', [TestController::class, 'delete']);
