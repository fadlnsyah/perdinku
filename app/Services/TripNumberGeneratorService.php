<?php

namespace App\Services;

use App\Models\BusinessTrip;

class TripNumberGeneratorService
{
    public function generate(): string
    {
        $year = now()->format('Y');
        $prefix = "PD-{$year}-";
        $latest = BusinessTrip::query()
            ->where('trip_number', 'like', $prefix.'%')
            ->latest('id')
            ->value('trip_number');

        $next = $latest ? ((int) substr($latest, -4)) + 1 : 1;

        return sprintf('%s%04d', $prefix, $next);
    }
}
