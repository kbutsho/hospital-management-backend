<?php

use App\Helpers\ROLE;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SerialController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VisitingHourController;
use Illuminate\Support\Facades\Route;

Route::prefix('signup')->group(function () {
    Route::post('/administrator', [AuthController::class, 'administratorSignup']);
    Route::post('/doctor', [AuthController::class, 'doctorSignup']);
    Route::get('/doctor/departmentList', [DepartmentController::class, 'getActiveDepartment']);
    Route::post('/assistant', [AuthController::class, 'assistantSignup']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/department/all', [DepartmentController::class, 'getActiveDepartment']);
Route::get('/doctor/all', [DoctorController::class, 'getAllActiveDoctor']);
Route::get('/room/all', [ChamberController::class, 'getAllActiveRoom']);
Route::get('/schedule/doctor-chamber', [ScheduleController::class, 'getDoctorAndChamberForCreateSchedule']);
Route::get('/serial/department-doctor-schedule', [ScheduleController::class, 'getDepartmentsDoctorsAndSchedulesForSerial']);
Route::get('/patient/{phone}', [PatientController::class, 'getPatientByPhone']);
Route::post('/patient/serial/create', [SerialController::class, 'createSerial']);
Route::get('/patient/serial/{id}', [SerialController::class, 'getSerialById']);

Route::prefix('doctor')->group(function () {
    Route::middleware(['jwt.verify', 'role:' . ROLE::DOCTOR])->group(function () {
        Route::get('/chamber/all', [ChamberController::class, 'getDoctorsChamber']);
        Route::delete('/chamber/{id}', [ChamberController::class, 'deleteChamber']);
        Route::patch('/chamber/{id}', [ChamberController::class, 'updateChamber']);


        Route::get('/appointment/all', [AppointmentController::class, 'getDoctorAppointments']);
        // Route::post('/appointment/update/status', [AppointmentController::class, 'updateAppointmentStatus']);
    });
});

Route::middleware(['jwt.verify', 'role:' . ROLE::DOCTOR . '|' . ROLE::ASSISTANT])->group(function () {
    Route::post('/create-schedule', [ScheduleController::class, 'createSchedule']);
    Route::post('/create-visiting-hour', [VisitingHourController::class, 'createVisitingHour']);
});

Route::prefix('administrator')->group(function () {
    Route::middleware(['jwt.verify', 'role:' . ROLE::ADMINISTRATOR])->group(function () {

        Route::get('/doctor/all', [DoctorController::class, 'getAllDoctorForAdministrator']);
        Route::post('/doctor/update/status', [DoctorController::class, 'updateDoctorStatus']);
        Route::delete('/doctor/{id}', [DoctorController::class, 'deleteDoctor']);

        Route::get('/assistant/all', [AssistantController::class, 'getAllAssistantWithChamber']);
        Route::post('/assistant/update/status', [AssistantController::class, 'updateAssistantStatus']);
        Route::delete('/assistant/{id}', [AssistantController::class, 'deleteAssistant']);

        Route::post('/chamber/create', [ChamberController::class, 'createAdministratorChamber']);
        Route::get('/chamber/all', [ChamberController::class, 'getAdministratorChamber']);
        Route::post('/chamber/update/status', [ChamberController::class, 'updateChamberStatus']);
        Route::delete('/chamber/{id}', [ChamberController::class, 'deleteChamber']);
        Route::get('/chamber/{id}', [ChamberController::class, 'getChamberDetails']);

        Route::post('/department/create', [DepartmentController::class, 'createDepartment']);
        Route::get('/department/all', [DepartmentController::class, 'getAllDepartmentWithDoctors']);
        Route::post('/department/update/status', [DepartmentController::class, 'updateDepartmentStatus']);
        Route::delete('/department/{id}', [DepartmentController::class, 'deleteDepartment']);
        Route::patch('/department/{id}', [DepartmentController::class, 'updateDepartment']);

        Route::post('/schedule/create', [ScheduleController::class, 'createSchedule']);
        Route::get('/schedule/all', [ScheduleController::class, 'getAllScheduleWithDoctorAndChamber']);
        Route::get('/schedule/time-slots', [ScheduleController::class, 'getAllTimeSlot']);
        Route::delete('/schedule/{id}', [ScheduleController::class, 'deleteSchedule']);
        Route::post('/schedule/update/status', [ScheduleController::class, 'updateScheduleStatus']);

        Route::get('/serial/all', [SerialController::class, 'getSerials']);
        Route::post('/serial/update/status', [SerialController::class, 'updateSerialStatus']);
        Route::delete('/serial/{id}', [SerialController::class, 'deleteSerial']);

        Route::get('/patient/all', [PatientController::class, 'getAllPatient']);

        Route::get('/appointment/all', [AppointmentController::class, 'getAppointments']);
        Route::post('/appointment/update/status', [AppointmentController::class, 'updateAppointmentStatus']);

        Route::get('/doctor-department-schedule', [SerialController::class, 'DoctorDepartmentAndScheduleList']);
    });
});

Route::post('/test/add', [TestController::class, 'create']);
Route::get('/test/all', [TestController::class, 'get']);
Route::get('/test', [TestController::class, 'getAll']);
Route::patch('/test/{id}', [TestController::class, 'update']);
Route::delete('/test/{id}', [TestController::class, 'delete']);
Route::post('/text/create', [TestController::class, 'createText']);
