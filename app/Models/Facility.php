<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function features(): HasMany
    {
        return $this->hasMany(FacilityFeature::class, 'facility_id', 'id');
    }

    public function getThumbnailAttribute($image)
    {
        return asset("storage/$image");
    }
}
