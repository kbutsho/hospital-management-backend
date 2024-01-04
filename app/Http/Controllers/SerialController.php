<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Validations\SerialValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SerialController extends Controller
{
    public function createSerial(Request $request)
    {
        try {
            $validation = new SerialValidation();
            $rules = $validation->createSerialRules;
            $messages = $validation->createSerialMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'serial created successfully!',
            ], 201);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
