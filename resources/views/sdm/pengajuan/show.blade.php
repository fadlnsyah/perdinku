@extends('layouts.app')

@php($pageTitle = 'Detail Persetujuan')

@section('content')
<div class="mx-auto max-w-5xl" x-data="{ rejectOpen: false }">
    <x-card class="overflow-hidden">
        <div class="border-b border-slate-200 p-8">
            <h1 class="text-4xl font-bold text-primary">Detail Persetujuan Perdin</h1>
            <p class="mt-2 text-lg text-slate-600">ID Pengajuan: {{ $trip->trip_number }}</p>
        </div>
        <div class="grid gap-8 p-8 md:grid-cols-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Nama Pegawai</p>
                <p class="mt-3 text-2xl font-bold">{{ $trip->user->name }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Kota Asal / Tujuan</p>
                <p class="mt-3 text-2xl font-bold">{{ $trip->originCity->name }} → {{ $trip->destinationCity->name }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Tanggal Perjalanan</p>
                <p class="mt-3 text-2xl font-bold">{{ $trip->start_date->format('d M Y') }} - {{ $trip->end_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Keterangan</p>
                <p class="mt-3 text-lg leading-8 text-slate-700">{{ $trip->purpose }}</p>
            </div>
        </div>
        <div class="grid gap-4 border-t border-slate-200 p-8 md:grid-cols-4">
            <x-card class="p-5"><p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Total Hari</p><p class="mt-3 text-3xl font-bold text-primary">{{ $trip->duration_days }} Hari</p></x-card>
            <x-card class="p-5"><p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Jarak Tempuh</p><p class="mt-3 text-3xl font-bold text-primary">{{ number_format($trip->distance_km, 0, ',', '.') }} Km</p></x-card>
            <x-card class="p-5"><p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Klasifikasi</p><p class="mt-3 text-xl font-bold text-primary">{{ $trip->classification }}</p></x-card>
            <x-card class="bg-sky-50 p-5"><p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Total Uang Perdin</p><p class="mt-3 text-3xl font-bold text-primary">{{ format_currency($trip->total_allowance_amount, $trip->currency) }}</p></x-card>
        </div>
        @if ($trip->status === 'pending')
            <div class="flex justify-end gap-3 border-t border-slate-200 p-8">
                <x-button variant="danger" @click="rejectOpen = true">Tolak Pengajuan</x-button>
                <form method="POST" action="{{ route('sdm.pengajuan.approve', $trip) }}">
                    @csrf
                    <x-button type="submit">Setujui</x-button>
                </form>
            </div>
        @elseif ($trip->rejection_reason)
            <div class="border-t border-slate-200 p-8">
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">{{ $trip->rejection_reason }}</div>
            </div>
        @endif
    </x-card>

    <x-modal x-show="rejectOpen">
        <form method="POST" action="{{ route('sdm.pengajuan.reject', $trip) }}" class="p-8">
            @csrf
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold">Alasan Penolakan</h2>
                <button type="button" class="text-slate-400" @click="rejectOpen = false">✕</button>
            </div>
            <textarea name="rejection_reason" rows="6" class="form-control mt-6"></textarea>
            @error('rejection_reason')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            <div class="mt-6 flex justify-end gap-3">
                <x-button type="button" variant="secondary" @click="rejectOpen = false">Batal</x-button>
                <x-button type="submit" variant="danger">Simpan Penolakan</x-button>
            </div>
        </form>
    </x-modal>
</div>
@endsection
