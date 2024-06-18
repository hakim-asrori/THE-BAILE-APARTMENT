<?php

namespace App\Enums;

class RoomFeatureEnum
{
    const FEATURES = 1;
    const BATHROOM = 2;
    const ENTERTAINMENT = 3;

    public static function get()
    {
        return [
            self::FEATURES => "Features",
            self::BATHROOM => "Bathroom and Toiletries",
            self::ENTERTAINMENT => "Entertainment",
        ];
    }

    public static function show($id)
    {
        return self::get()[$id];
    }
}
