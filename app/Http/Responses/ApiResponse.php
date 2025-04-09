<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function Success($data, string $message, $status, $responseCode)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'responseCode' => $responseCode
        ]);
    }
    public static function Error($data, string $message, $status, $responseCode)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'responseCode' => $responseCode
        ]);
    }
}
