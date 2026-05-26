<?php

namespace App\Http\Controllers\Sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\RejectBusinessTripRequest;
use App\Models\BusinessTrip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SdmBusinessTripController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->string('tab', 'new')->toString();
        $query = BusinessTrip::query()
            ->with(['user', 'originCity', 'destinationCity'])
            ->latest();

        if ($tab === 'history') {
            $query->whereIn('status', ['approved', 'rejected']);
        } else {
            $query->where('status', 'pending');
        }

        return view('sdm.pengajuan.index', [
            'trips' => $query->paginate(10)->withQueryString(),
            'tab' => $tab,
            'stats' => [
                'pending' => BusinessTrip::where('status', 'pending')->count(),
                'approved' => BusinessTrip::where('status', 'approved')->count(),
                'rejected' => BusinessTrip::where('status', 'rejected')->count(),
            ],
        ]);
    }

    public function show(BusinessTrip $businessTrip): View
    {
        return view('sdm.pengajuan.show', [
            'trip' => $businessTrip->load(['user', 'originCity', 'destinationCity']),
        ]);
    }

    public function approve(Request $request, BusinessTrip $businessTrip): RedirectResponse
    {
        abort_unless($businessTrip->status === 'pending', 403);

        $businessTrip->update([
            'status' => 'approved',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'rejection_reason' => null,
            'rejected_by' => null,
            'rejected_at' => null,
        ]);

        return redirect()->route('sdm.pengajuan.show', $businessTrip)->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(RejectBusinessTripRequest $request, BusinessTrip $businessTrip): RedirectResponse
    {
        abort_unless($businessTrip->status === 'pending', 403);

        $businessTrip->update([
            'status' => 'rejected',
            'rejection_reason' => $request->string('rejection_reason')->toString(),
            'rejected_by' => $request->user()->id,
            'rejected_at' => now(),
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()->route('sdm.pengajuan.show', $businessTrip)->with('success', 'Pengajuan berhasil ditolak.');
    }
}
