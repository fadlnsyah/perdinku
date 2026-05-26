<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $cities = City::query()
            ->when($search, function ($query, $search) {
                $query->where(fn ($subQuery) => $subQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%"));
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.cities.index', [
            'cities' => $cities,
            'search' => $search,
            'stats' => [
                'total' => City::count(),
                'provinces' => City::whereNotNull('province')->distinct('province')->count('province'),
                'foreign' => City::where('is_foreign', true)->count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.cities.create', ['city' => new City()]);
    }

    public function store(StoreCityRequest $request): RedirectResponse
    {
        City::create($this->payload($request->validated()));

        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil ditambahkan.');
    }

    public function edit(City $city): View
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(UpdateCityRequest $request, City $city): RedirectResponse
    {
        $city->update($this->payload($request->validated()));

        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil diperbarui.');
    }

    public function destroy(City $city): RedirectResponse
    {
        if ($city->originTrips()->exists() || $city->destinationTrips()->exists()) {
            return back()->with('error', 'Kota tidak bisa dihapus karena sudah dipakai pada pengajuan.');
        }

        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'Kota berhasil dihapus.');
    }

    protected function payload(array $validated): array
    {
        if ($validated['is_foreign']) {
            $validated['province'] = null;
            $validated['island'] = null;
        }

        return $validated;
    }
}
