<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Services\AllowanceCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TripEstimationController extends Controller
{
    public function __construct(
        protected AllowanceCalculatorService $allowanceCalculatorService
    ) {
    }

    public function estimate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'origin_city_id' => ['required', 'exists:cities,id'],
            'destination_city_id' => ['required', 'exists:cities,id', 'different:origin_city_id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $origin = City::findOrFail($validated['origin_city_id']);
        $destination = City::findOrFail($validated['destination_city_id']);

        return response()->json(
            $this->allowanceCalculatorService->calculate(
                $origin,
                $destination,
                $validated['start_date'],
                $validated['end_date'],
            )
        );
    }
}
