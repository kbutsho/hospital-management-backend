<?php

namespace App\Helpers;

class ValidationHandler
{
    public static function handleValidation($validator)
    {
        return response()->json([
            'status' => false,
            'message' => 'validation error!',
            'error' => $validator->errors(),
        ], 422);
    }
}
