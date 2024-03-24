<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHTTPHelper{
    public static function success($statusCode, $message, $data = null, $redirect = null){
        return ResponseHTTPHelper::returnFormatedJSON(true, $statusCode, $message, $data, $redirect);
    }

    public static function error($statusCode, $message, $data = null, $redirect = null) {
        return ResponseHTTPHelper::returnFormatedJSON(false, $statusCode, $message, $data, $redirect);
    }

    private static function returnFormatedJSON(bool $success, int $statusCode, string $message, array|bool|object|string $data, string|bool $redirect = null): JsonResponse {
        $response = [
            "success" => $success,
            "message" => $message
        ];

        if($data) {
            if(is_string($data)) {
                $response['data'] = json_decode($data);
                $response['data'] = $response['data'];
            }

            $response['data'] = $data;
        }
        if($redirect) $response['redirect'] = $redirect;

        http_response_code($statusCode);
        return response()->json($response, $statusCode);
    }
}