<?php

namespace Database\Seeders;

use App\Models\BusinessTrip;
use App\Models\City;
use App\Models\User;
use App\Services\AllowanceCalculatorService;
use App\Services\TripNumberGeneratorService;
use Illuminate\Database\Seeder;

class BusinessTripSeeder extends Seeder
{
    public function __construct(
        protected AllowanceCalculatorService $allowanceCalculatorService,
        protected TripNumberGeneratorService $tripNumberGeneratorService,
    ) {
    }

    public function run(): void
    {
        $employee = User::where('username', 'pegawai')->firstOrFail();
        $sdm = User::where('username', 'sdm')->firstOrFail();

        $trips = [
            [
                'origin' => 'Bandung',
                'destination' => 'Surabaya',
                'purpose' => 'Audit tahunan cabang operasional Jawa Timur.',
                'start_date' => now()->addDays(2)->toDateString(),
                'end_date' => now()->addDays(5)->toDateString(),
                'status' => 'pending',
                'rejection_reason' => null,
            ],
            [
                'origin' => 'Jakarta',
                'destination' => 'Denpasar',
                'purpose' => 'Koordinasi vendor dan evaluasi proyek regional Bali.',
                'start_date' => now()->subDays(15)->toDateString(),
                'end_date' => now()->subDays(13)->toDateString(),
                'status' => 'approved',
                'rejection_reason' => null,
            ],
            [
                'origin' => 'Jakarta',
                'destination' => 'Singapore',
                'purpose' => 'Partisipasi konferensi teknologi dan pertemuan mitra luar negeri.',
                'start_date' => now()->subDays(8)->toDateString(),
                'end_date' => now()->subDays(6)->toDateString(),
                'status' => 'rejected',
                'rejection_reason' => 'Dokumen undangan luar negeri dan TOR belum lengkap.',
            ],
        ];

        foreach ($trips as $data) {
            $origin = City::where('name', $data['origin'])->firstOrFail();
            $destination = City::where('name', $data['destination'])->firstOrFail();
            $calculation = $this->allowanceCalculatorService->calculate(
                $origin,
                $destination,
                $data['start_date'],
                $data['end_date'],
            );

            BusinessTrip::updateOrCreate(
                ['purpose' => $data['purpose']],
                [
                    'trip_number' => $this->tripNumberGeneratorService->generate(),
                    'user_id' => $employee->id,
                    'origin_city_id' => $origin->id,
                    'destination_city_id' => $destination->id,
                    'purpose' => $data['purpose'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    ...$calculation,
                    'status' => $data['status'],
                    'approved_by' => $data['status'] === 'approved' ? $sdm->id : null,
                    'approved_at' => $data['status'] === 'approved' ? now()->subDays(12) : null,
                    'rejected_by' => $data['status'] === 'rejected' ? $sdm->id : null,
                    'rejected_at' => $data['status'] === 'rejected' ? now()->subDays(5) : null,
                    'rejection_reason' => $data['rejection_reason'],
                ]
            );
        }
    }
}
