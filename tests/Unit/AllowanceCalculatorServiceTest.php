<?php

use App\Models\City;
use App\Services\AllowanceCalculatorService;

beforeEach(function () {
    $this->service = app(AllowanceCalculatorService::class);
});

test('returns no allowance for trips up to 60 km', function () {
    $origin = new City([
        'name' => 'A',
        'province' => 'Jawa Barat',
        'island' => 'Jawa',
        'is_foreign' => false,
        'latitude' => -6.9175000,
        'longitude' => 107.6191000,
    ]);

    $destination = new City([
        'name' => 'B',
        'province' => 'Jawa Barat',
        'island' => 'Jawa',
        'is_foreign' => false,
        'latitude' => -6.9500000,
        'longitude' => 107.6500000,
    ]);

    $result = $this->service->calculate($origin, $destination, '2026-05-01', '2026-05-02');

    expect($result['duration_days'])->toEqual(2)
        ->and($result['classification'])->toBe('Tidak Mendapat Uang Saku')
        ->and($result['currency'])->toBe('IDR')
        ->and($result['daily_allowance_amount'])->toEqual(0.0)
        ->and($result['total_allowance_amount'])->toEqual(0.0);
});

test('returns within province allowance for trips above 60 km in same province', function () {
    $origin = new City([
        'name' => 'Bandung',
        'province' => 'Jawa Barat',
        'island' => 'Jawa',
        'is_foreign' => false,
        'latitude' => -6.9175000,
        'longitude' => 107.6191000,
    ]);

    $destination = new City([
        'name' => 'Cirebon',
        'province' => 'Jawa Barat',
        'island' => 'Jawa',
        'is_foreign' => false,
        'latitude' => -6.7320000,
        'longitude' => 108.5523000,
    ]);

    $result = $this->service->calculate($origin, $destination, '2026-05-01', '2026-05-03');

    expect($result['classification'])->toBe('Dalam Provinsi')
        ->and($result['daily_allowance_amount'])->toEqual(200000.0)
        ->and($result['total_allowance_amount'])->toEqual(600000.0);
});

test('returns same island allowance for inter province trips above 60 km', function () {
    $origin = new City([
        'name' => 'Bandung',
        'province' => 'Jawa Barat',
        'island' => 'Jawa',
        'is_foreign' => false,
        'latitude' => -6.9175000,
        'longitude' => 107.6191000,
    ]);

    $destination = new City([
        'name' => 'Surabaya',
        'province' => 'Jawa Timur',
        'island' => 'Jawa',
        'is_foreign' => false,
        'latitude' => -7.2575000,
        'longitude' => 112.7521000,
    ]);

    $result = $this->service->calculate($origin, $destination, '2026-05-01', '2026-05-04');

    expect($result['classification'])->toBe('Luar Provinsi - Satu Pulau')
        ->and($result['daily_allowance_amount'])->toEqual(250000.0)
        ->and($result['total_allowance_amount'])->toEqual(1000000.0);
});

test('returns different island allowance for trips above 60 km', function () {
    $origin = new City([
        'name' => 'Bandung',
        'province' => 'Jawa Barat',
        'island' => 'Jawa',
        'is_foreign' => false,
        'latitude' => -6.9175000,
        'longitude' => 107.6191000,
    ]);

    $destination = new City([
        'name' => 'Medan',
        'province' => 'Sumatera Utara',
        'island' => 'Sumatera',
        'is_foreign' => false,
        'latitude' => 3.5952000,
        'longitude' => 98.6722000,
    ]);

    $result = $this->service->calculate($origin, $destination, '2026-05-01', '2026-05-03');

    expect($result['classification'])->toBe('Luar Provinsi - Beda Pulau')
        ->and($result['daily_allowance_amount'])->toEqual(300000.0)
        ->and($result['total_allowance_amount'])->toEqual(900000.0);
});

test('returns usd allowance for foreign trips', function () {
    $origin = new City([
        'name' => 'Jakarta',
        'province' => 'DKI Jakarta',
        'island' => 'Jawa',
        'is_foreign' => false,
        'latitude' => -6.2088000,
        'longitude' => 106.8456000,
    ]);

    $destination = new City([
        'name' => 'Singapore',
        'province' => null,
        'island' => null,
        'is_foreign' => true,
        'latitude' => 1.3521000,
        'longitude' => 103.8198000,
    ]);

    $result = $this->service->calculate($origin, $destination, '2026-05-01', '2026-05-03');

    expect($result['classification'])->toBe('Luar Negeri')
        ->and($result['currency'])->toBe('USD')
        ->and($result['daily_allowance_amount'])->toEqual(50.0)
        ->and($result['total_allowance_amount'])->toEqual(150.0);
});
