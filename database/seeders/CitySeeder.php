<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Bandung', 'province' => 'Jawa Barat', 'island' => 'Jawa', 'is_foreign' => false, 'latitude' => -6.9175000, 'longitude' => 107.6191000],
            ['name' => 'Jakarta', 'province' => 'DKI Jakarta', 'island' => 'Jawa', 'is_foreign' => false, 'latitude' => -6.2088000, 'longitude' => 106.8456000],
            ['name' => 'Surabaya', 'province' => 'Jawa Timur', 'island' => 'Jawa', 'is_foreign' => false, 'latitude' => -7.2575000, 'longitude' => 112.7521000],
            ['name' => 'Denpasar', 'province' => 'Bali', 'island' => 'Bali', 'is_foreign' => false, 'latitude' => -8.6500000, 'longitude' => 115.2167000],
            ['name' => 'Medan', 'province' => 'Sumatera Utara', 'island' => 'Sumatera', 'is_foreign' => false, 'latitude' => 3.5952000, 'longitude' => 98.6722000],
            ['name' => 'Makassar', 'province' => 'Sulawesi Selatan', 'island' => 'Sulawesi', 'is_foreign' => false, 'latitude' => -5.1477000, 'longitude' => 119.4327000],
            ['name' => 'Singapore', 'province' => null, 'island' => null, 'is_foreign' => true, 'latitude' => 1.3521000, 'longitude' => 103.8198000],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(['name' => $city['name']], $city);
        }
    }
}
