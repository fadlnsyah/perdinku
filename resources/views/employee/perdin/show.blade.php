@extends('layouts.app')

@php($pageTitle = 'Detail Pengajuan')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold">{{ $trip->trip_number }}</h1>
            <p class="mt-2 text-lg text-slate-600">{{ $trip->originCity->name }} → {{ $trip->destinationCity->name }}</p>
        </div>
        <x-badge :status="$trip->status" />
    </div>

    <x-card class="p-8">
        <div class="grid gap-6 md:grid-cols-2">
            <div><p class="text-sm text-slate-500">Tanggal</p><p class="mt-2 text-lg font-semibold">{{ $trip->start_date->format('d M Y') }} - {{ $trip->end_date->format('d M Y') }}</p></div>
            <div><p class="text-sm text-slate-500">Klasifikasi</p><p class="mt-2 text-lg font-semibold">{{ $trip->classification }}</p></div>
            <div><p class="text-sm text-slate-500">Durasi</p><p class="mt-2 text-lg font-semibold">{{ $trip->duration_days }} Hari</p></div>
            <div><p class="text-sm text-slate-500">Jarak</p><p class="mt-2 text-lg font-semibold">{{ number_format($trip->distance_km, 2, ',', '.') }} KM</p></div>
            <div><p class="text-sm text-slate-500">Rate Harian</p><p class="mt-2 text-lg font-semibold">{{ format_currency($trip->daily_allowance_amount, $trip->currency) }}</p></div>
            <div><p class="text-sm text-slate-500">Total Uang</p><p class="mt-2 text-lg font-semibold">{{ format_currency($trip->total_allowance_amount, $trip->currency) }}</p></div>
        </div>
        <div class="mt-6 border-t border-slate-200 pt-6">
            <p class="text-sm text-slate-500">Keterangan</p>
            <p class="mt-2 text-base leading-8 text-slate-700">{{ $trip->purpose }}</p>
        </div>
        @if ($trip->rejection_reason)
            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                <p class="text-sm font-semibold text-red-700">Alasan Penolakan</p>
                <p class="mt-2 text-sm text-red-600">{{ $trip->rejection_reason }}</p>
            </div>
        @endif
    </x-card>
</div>
@endsection
