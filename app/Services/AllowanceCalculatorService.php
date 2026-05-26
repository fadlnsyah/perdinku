<?php

namespace App\Services;

use App\Models\City;
use Carbon\Carbon;

class AllowanceCalculatorService
{
    public function __construct(
        protected DistanceCalculatorService $distanceCalculatorService
    ) {
    }

    public function calculate(City $origin, City $destination, string $startDate, string $endDate): array
    {
        $duration = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;
        $distance = $this->distanceCalculatorService->calculate(
            $origin->latitude,
            $origin->longitude,
            $destination->latitude,
            $destination->longitude,
        );

        $classification = 'Tidak Mendapat Uang Saku';
        $daily = 0.0;
        $currency = 'IDR';

        if ($destination->is_foreign) {
            $classification = 'Luar Negeri';
            $daily = 50;
            $currency = 'USD';
        } elseif ($distance > 60) {
            if ($origin->province === $destination->province) {
                $classification = 'Dalam Provinsi';
                $daily = 200000;
            } elseif ($origin->island === $destination->island) {
                $classification = 'Luar Provinsi - Satu Pulau';
                $daily = 250000;
            } else {
                $classification = 'Luar Provinsi - Beda Pulau';
                $daily = 300000;
            }
        }

        return [
            'duration_days' => $duration,
            'distance_km' => $distance,
            'classification' => $classification,
            'daily_allowance_amount' => $daily,
            'currency' => $currency,
            'total_allowance_amount' => $daily * $duration,
        ];
    }
}
