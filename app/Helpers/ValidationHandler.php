<?php

namespace App\Helpers;

class ValidationHandler
{
    public static function handleValidation($validator)
    {
        return response()->json([
            'status' => false,
            'message' => 'please fill up all required fields!',
            'error' => $validator->errors(),
        ], 422);
    }
}
