<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'province',
        'island',
        'is_foreign',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'is_foreign' => 'boolean',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function originTrips(): HasMany
    {
        return $this->hasMany(BusinessTrip::class, 'origin_city_id');
    }

    public function destinationTrips(): HasMany
    {
        return $this->hasMany(BusinessTrip::class, 'destination_city_id');
    }
}
