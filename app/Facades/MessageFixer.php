<?php

namespace App\Facades;

use Illuminate\Http\JsonResponse;

class MessageFixer extends JsonResponse
{
    const WARNING = "WARNING";
    const SUCCESS = "SUCCESS";
    const ERROR = "ERROR";

    public static function warning($messages, $code = self::HTTP_BAD_REQUEST)
    {
        return response()->json([
            "code" => $code,
            "status" => self::WARNING,
            "messages" => $messages
        ], $code);
    }

    public static function error($messages, $code = self::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json([
            "code" => $code,
            "status" => self::ERROR,
            "messages" => $messages
        ], $code);
    }

    public static function created($messages, $code = self::HTTP_CREATED)
    {
        return response()->json([
            "code" => $code,
            "status" => self::SUCCESS,
            "messages" => $messages
        ], $code);
    }

    public static function success($messages, $data = [], $code = self::HTTP_OK)
    {
        return response()->json([
            "code" => $code,
            "status" => self::SUCCESS,
            "messages" => $messages,
            "data" => $data
        ], $code);
    }
}
