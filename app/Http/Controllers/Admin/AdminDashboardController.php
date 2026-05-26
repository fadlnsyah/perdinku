<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessTrip;
use App\Models\City;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'cities' => City::count(),
                'foreign_cities' => City::where('is_foreign', true)->count(),
                'users' => User::count(),
                'active_users' => User::where('status', 'active')->count(),
                'pending_trips' => BusinessTrip::where('status', 'pending')->count(),
            ],
            'latestTrips' => BusinessTrip::with(['user', 'originCity', 'destinationCity'])
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
