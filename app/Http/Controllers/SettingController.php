<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Setting;
use App\Validations\SettingValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function showSiteInfo()
    {
        try {
            $info = Setting::all();
            return response()->json([
                'status' => true,
                'message' => "items fetched successfully!",
                'data' => $info
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateSiteInfo(Request $request)
    {
        try {
            $validation = new SettingValidation();
            $rules = $validation->updateSettingRules;
            $messages = $validation->updateSettingMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $info = Setting::first();
            $info->organization_name = $request->organization_name;
            $info->email = $request->email;
            $info->phone = $request->phone;
            $info->address = $request->address;
            $info->facebook = $request->facebook;
            $info->youtube = $request->youtube;
            $info->save();

            return response()->json([
                'status' => true,
                'message' => "update successfully!",
                'data' => $info
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function siteInfo()
    {
        try {
            $info = Setting::first();
            return response()->json([
                'status' => true,
                'message' => 'site information retrieved successfully!',
                'data' => $info
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
