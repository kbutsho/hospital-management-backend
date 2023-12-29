<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\STATUS;
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
            $data->status = STATUS::ACTIVE;
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
    // public function getAllDepartment()
    // {
    //     try {
    //         $data = Department::select('id', 'name')
    //             ->where('status', 'active')
    //             ->get();
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'department retrieved successfully!',
    //             'data' => $data,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return ExceptionHandler::handleException($e);
    //     }
    // }
    public function getActiveDepartment()
    {
        try {
            $data = Department::select('id', 'name')
                ->where('status', 'active')
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'department retrieved successfully!',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getAllDepartmentWithDoctors(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $sortOrder = $request->query('sortOrder', 'asc');
            $sortBy = $request->query('sortBy', 'departments.id');

            $query = Department::select('departments.id', 'departments.name', 'departments.status')
                ->selectRaw('SUM(users.status = "active") as activeDoctor')
                ->selectRaw('SUM(users.status = "pending") as pendingDoctor')
                ->selectRaw('SUM(users.status = "disable") as disableDoctor')
                ->leftJoin('doctors', 'departments.id', '=', 'doctors.department_id')
                ->leftJoin('users', 'doctors.user_id', '=', 'users.id')
                ->groupBy('departments.id', 'departments.name', 'departments.status')
                ->with(['doctors'])
                ->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('departments.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('departments.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('departments.status', 'like', '%' . $searchTerm . '%');
                });
            }
            if ($statusFilter) {
                $query->whereRaw('LOWER(departments.status) = ?', strtolower($statusFilter));
            }
            $paginationData = $query->paginate($perPage);
            $total = Department::count();
            return response()->json([
                'status' => true,
                'message' => count($paginationData->items()) . " items fetched successfully!",
                'fetchedItems' => $paginationData->total(),
                'currentPage' => $paginationData->currentPage(),
                'totalItems' => $total,
                'data' => $paginationData->items()
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
    public function updateDepartmentStatus(Request $request)
    {
        try {
            $validation = new DepartmentValidation();
            $rules = $validation->updateDepartmentStatusRules;
            $messages = $validation->updateDepartmentStatusMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $isExist = Department::where('id', '=', $request->id)->first();
            if ($isExist) {
                $isExist->status = $request->status;
                $isExist->save();
                return response()->json([
                    'status' => true,
                    'message' => 'status updated successfully!',
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'department not found!',
            ], 404);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
