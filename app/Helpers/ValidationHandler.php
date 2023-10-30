<?php

namespace App\Helpers;

class ValidationHandler
{
    public static function handleValidation($validator)
    {
        return response()->json([
            'status' => 'failed!',
            'message' => 'validation error!',
            'error' => $validator->errors(),
        ], 422);
    }
}
