<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function getImageAttribute($image)
    {
        return asset("storage/$image");
    }
}
