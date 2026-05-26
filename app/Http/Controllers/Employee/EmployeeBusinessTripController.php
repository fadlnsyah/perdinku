<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessTripRequest;
use App\Models\BusinessTrip;
use App\Models\City;
use App\Services\AllowanceCalculatorService;
use App\Services\TripNumberGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeBusinessTripController extends Controller
{
    public function __construct(
        protected AllowanceCalculatorService $allowanceCalculatorService,
        protected TripNumberGeneratorService $tripNumberGeneratorService,
    ) {
    }

    public function index(Request $request): View
    {
        return view('employee.perdin.index', [
            'trips' => $request->user()->businessTrips()
                ->with(['originCity', 'destinationCity'])
                ->latest()
                ->paginate(10),
            'stats' => [
                'total' => $request->user()->businessTrips()->count(),
                'total_amount' => $request->user()->businessTrips()->sum('total_allowance_amount'),
                'pending' => $request->user()->businessTrips()->where('status', 'pending')->count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('employee.perdin.create', [
            'cities' => City::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreBusinessTripRequest $request): RedirectResponse
    {
        $origin = City::findOrFail($request->integer('origin_city_id'));
        $destination = City::findOrFail($request->integer('destination_city_id'));
        $calculation = $this->allowanceCalculatorService->calculate(
            $origin,
            $destination,
            $request->string('start_date')->toString(),
            $request->string('end_date')->toString(),
        );

        BusinessTrip::create([
            'trip_number' => $this->tripNumberGeneratorService->generate(),
            'user_id' => $request->user()->id,
            'origin_city_id' => $origin->id,
            'destination_city_id' => $destination->id,
            'purpose' => $request->string('purpose')->toString(),
            'start_date' => $request->string('start_date')->toString(),
            'end_date' => $request->string('end_date')->toString(),
            ...$calculation,
            'status' => 'pending',
        ]);

        return redirect()->route('pegawai.perdin.index')->with('success', 'Pengajuan perjalanan dinas berhasil dibuat.');
    }

    public function show(Request $request, BusinessTrip $businessTrip): View
    {
        abort_unless($businessTrip->user_id === $request->user()->id, 403);

        return view('employee.perdin.show', [
            'trip' => $businessTrip->load(['originCity', 'destinationCity', 'approver', 'rejector']),
        ]);
    }
}
