<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Specialization;
use App\Validations\SpecialistValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecializationController extends Controller
{
    public function createSpecialist(Request $request)
    {
        try {
            $validation = new SpecialistValidation();
            $rules = $validation->createSpecialistRules;
            $messages = $validation->createSpecialistMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $isExist = Specialization::where('name', '=', $request->name)->first();
            if ($isExist) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        "name" => "phone already used!"
                    ],
                    'message' => 'failed to create specialization!',
                ], 409);
            }
            $data = new Specialization();
            $data->name = $request->name();
            $data->save();

            return response()->json([
                'status' => true,
                'message' => 'specialization created successfully!',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getAllSpecialization()
    {
        try {
            $specialization = Specialization::all();
            return response()->json([
                'status' => true,
                'message' => 'specialization retrieved successfully!',
                'data' => $specialization,
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
