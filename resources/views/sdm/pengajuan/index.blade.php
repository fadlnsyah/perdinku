@extends('layouts.app')

@php($pageTitle = 'Manajemen Pengajuan')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-4xl font-bold tracking-tight">Manajemen Pengajuan Perjalanan Dinas</h1>
        <p class="mt-2 text-lg text-slate-600">Pantau pengajuan baru dan riwayat persetujuan perjalanan dinas pegawai.</p>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <x-card class="p-6"><p class="text-sm font-semibold text-slate-500">Menunggu</p><p class="mt-3 text-4xl font-bold">{{ $stats['pending'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm font-semibold text-slate-500">Disetujui</p><p class="mt-3 text-4xl font-bold">{{ $stats['approved'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm font-semibold text-slate-500">Ditolak</p><p class="mt-3 text-4xl font-bold">{{ $stats['rejected'] }}</p></x-card>
    </div>

    <x-table>
        <div class="border-b border-slate-200 px-6 pt-6">
            <div class="flex gap-6 text-sm font-semibold">
                <a href="{{ route('sdm.pengajuan.index', ['tab' => 'new']) }}" class="{{ $tab === 'new' ? 'border-b-2 border-primary pb-4 text-primary' : 'pb-4 text-slate-500' }}">Pengajuan Baru</a>
                <a href="{{ route('sdm.pengajuan.index', ['tab' => 'history']) }}" class="{{ $tab === 'history' ? 'border-b-2 border-primary pb-4 text-primary' : 'pb-4 text-slate-500' }}">History Pengajuan</a>
            </div>
        </div>
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Nama Pegawai</th>
                    <th class="px-6 py-4">Kota</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Keterangan</th>
                    <th class="px-6 py-4">Durasi</th>
                    <th class="px-6 py-4">Jarak</th>
                    <th class="px-6 py-4">Total Uang</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($trips as $trip)
                    <tr class="text-sm text-slate-700">
                        <td class="px-6 py-5">{{ $loop->iteration }}</td>
                        <td class="px-6 py-5 font-semibold text-slate-900">{{ $trip->user->name }}</td>
                        <td class="px-6 py-5">{{ $trip->originCity->name }} → {{ $trip->destinationCity->name }}</td>
                        <td class="px-6 py-5">{{ $trip->start_date->format('d M Y') }} - {{ $trip->end_date->format('d M Y') }}</td>
                        <td class="px-6 py-5">{{ \Illuminate\Support\Str::limit($trip->purpose, 30) }}</td>
                        <td class="px-6 py-5">{{ $trip->duration_days }} Hari</td>
                        <td class="px-6 py-5">{{ number_format($trip->distance_km, 0, ',', '.') }} KM</td>
                        <td class="px-6 py-5 font-semibold">{{ format_currency($trip->total_allowance_amount, $trip->currency) }}</td>
                        <td class="px-6 py-5"><a href="{{ route('sdm.pengajuan.show', $trip) }}" class="font-semibold text-primary">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="px-6 py-10 text-center text-slate-500">Tidak ada data pengajuan.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="border-t border-slate-200 px-6 py-4">{{ $trips->links() }}</div>
    </x-table>
</div>
@endsection
