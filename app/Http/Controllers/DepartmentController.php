<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Department;
use App\Validations\DepartmentValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function createDepartment(Request $request)
    {
        try {
            $validation = new DepartmentValidation();
            $rules = $validation->createDepartmentRules;
            $messages = $validation->createDepartmentMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $isExist = Department::where('name', '=', $request->name)->first();
            if ($isExist) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        "name" => "department already exist!"
                    ],
                    'message' => 'failed to create department!',
                ], 409);
            }
            $data = new Department();
            $data->name = $request->name;
            $data->save();
            return response()->json([
                'status' => true,
                'message' => 'department created successfully!',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getAllDepartment()
    {
        try {
            $departments = Department::all();
            return response()->json([
                'status' => true,
                'message' => 'departments retrieved successfully!',
                'data' => $departments,
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function deleteDepartment($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();
            return response()->json([
                'status' => true,
                'message' => 'department deleted successfully!'
            ], 204);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateDepartment(Request $request, $id)
    {
        try {

            $validation = new DepartmentValidation();
            $rules = $validation->updateDepartmentRules;
            $messages = $validation->updateDepartmentMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $isExist = Department::where('name', '=', $request->name)->first();
            if ($isExist) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        "name" => "department already exist!"
                    ],
                    'message' => 'failed to update department!',
                ], 409);
            };
            $department = Department::findOrFail($id);
            $department->name = $request->name;
            $department->save();
            return response()->json([
                'status' => true,
                'message' => 'department updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
