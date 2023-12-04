<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Models\User;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    public function getAllAssistant()
    {
        try {
            $assistants = User::where('role', 'assistant')
                ->join('assistants', 'users.id', '=', 'assistants.user_id')
                ->join('doctors', 'doctors.id', '=', 'assistants.doctor_id')
                ->join('chambers', 'chambers.id', '=', 'assistants.chamber_id')
                ->select(
                    'users.id as userId',
                    'users.email',
                    'users.phone',
                    'users.status',
                    'assistants.id as assistantId',
                    'assistants.name',
                    'assistants.address',
                    'doctors.name as doctorName',
                    'chambers.address as chamberAddress',
                )
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'assistants retrieved successfully!',
                'data' => $assistants,
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
