<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Models\Appointment;
use App\Models\Chamber;
use App\Models\Department;
use App\Models\Patient;
use App\Models\User;

class AdministratorController extends Controller
{
    public function dashboardInfo()
    {
        try {
            $doctorCounts = User::selectRaw('
                SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "disabled" THEN 1 ELSE 0 END) as disabled
            ')->where('role', 'doctor')->first();

            $assistantCounts = User::selectRaw('
                SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "disabled" THEN 1 ELSE 0 END) as disabled
            ')->where('role', 'assistant')->first();

            $departmentCounts = Department::selectRaw('
                SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "disabled" THEN 1 ELSE 0 END) as disabled
            ')->first();

            $chamberCounts = Chamber::selectRaw('
                SUM(CASE WHEN status = "active" THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "disabled" THEN 1 ELSE 0 END) as disabled
            ')->first();

            $appointmentCounts = Appointment::selectRaw('
                SUM(CASE WHEN status = "paid" THEN 1 ELSE 0 END) as paid,
                SUM(CASE WHEN status = "in progress" THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN status = "closed" THEN 1 ELSE 0 END) as closed
                ')->first();

            $patientCounts = Patient::count();

            $data = [
                'doctor' => $doctorCounts,
                'assistant' => $assistantCounts,
                'department' => $departmentCounts,
                'chamber' => $chamberCounts,
                'appointment' => $appointmentCounts,
                'patient' => $patientCounts
            ];
            return response()->json([
                'status' => true,
                'message' => "items fetched successfully!",
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
