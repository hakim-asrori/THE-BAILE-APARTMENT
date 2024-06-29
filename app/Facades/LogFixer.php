<?php

namespace App\Facades;

use Illuminate\Support\Facades\Log;

class LogFixer
{
    public static function info($fileName, $message)
    {
        Log::build([
            'driver' => 'single',
            'level' => 'debug',
            'path' => storage_path("logs/" . date('Ym') . "/" . date('Ymd') . "/$fileName.log")
        ])->info($message);
    }

    public static function error($fileName, $message)
    {
        Log::build([
            'driver' => 'single',
            'level' => 'debug',
            'path' => storage_path("logs/" . date('Ym') . "/" . date('Ymd') . "/$fileName.log")
        ])->error($message);
    }
}
