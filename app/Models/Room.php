<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function features(): HasMany
    {
        return $this->hasMany(RoomFeature::class, 'room_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(RoomImage::class, 'room_id', 'id');
    }
}
