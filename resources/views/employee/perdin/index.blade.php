@extends('layouts.app')

@php($pageTitle = $isHistory ? 'Riwayat Pengajuan' : 'Daftar Perjalanan Dinas')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-4xl font-bold tracking-tight text-slate-900">{{ $isHistory ? 'Riwayat Pengajuan Perjalanan Dinas' : 'Daftar Perjalanan Dinas' }}</h1>
            <p class="mt-2 text-lg text-slate-600">{{ $isHistory ? 'Lihat pengajuan yang sudah diproses, baik disetujui maupun ditolak oleh SDM.' : 'Kelola dan pantau seluruh rencana perjalanan dinas Anda di sini.' }}</p>
        </div>
        <a href="{{ route('pegawai.perdin.create') }}"><x-button>Tambah Perdin</x-button></a>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('pegawai.perdin.index') }}" class="{{ $isHistory ? 'border border-slate-200 bg-white text-slate-700' : 'bg-primary text-white' }} rounded-full px-4 py-2 text-sm font-semibold transition">
            Semua Pengajuan
        </a>
        <a href="{{ route('pegawai.perdin.index', ['tab' => 'history']) }}" class="{{ $isHistory ? 'bg-primary text-white' : 'border border-slate-200 bg-white text-slate-700' }} rounded-full px-4 py-2 text-sm font-semibold transition">
            Sudah Diproses
        </a>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <x-card class="p-6">
            <p class="text-sm font-semibold text-slate-500">Total Perjalanan</p>
            <p class="mt-3 text-4xl font-bold">{{ $stats['total'] }}</p>
        </x-card>
        <x-card class="p-6">
            <p class="text-sm font-semibold text-slate-500">Total Uang Perdin</p>
            <p class="mt-3 text-4xl font-bold">{{ format_currency($stats['total_amount']) }}</p>
        </x-card>
        <x-card class="p-6">
            <p class="text-sm font-semibold text-slate-500">Menunggu Persetujuan</p>
            <p class="mt-3 text-4xl font-bold">{{ $stats['pending'] }}</p>
        </x-card>
    </div>

    <x-table>
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Kota</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Keterangan</th>
                    <th class="px-6 py-4">Durasi</th>
                    <th class="px-6 py-4">Jarak</th>
                    <th class="px-6 py-4">Total Uang</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white text-sm text-slate-700">
                @forelse ($trips as $trip)
                    <tr>
                        <td class="px-6 py-5 font-semibold text-slate-900">{{ $trip->trip_number }}</td>
                        <td class="px-6 py-5">{{ $trip->originCity->name }} -> {{ $trip->destinationCity->name }}</td>
                        <td class="px-6 py-5">{{ $trip->start_date->format('d M Y') }} - {{ $trip->end_date->format('d M Y') }}</td>
                        <td class="px-6 py-5">{{ \Illuminate\Support\Str::limit($trip->purpose, 36) }}</td>
                        <td class="px-6 py-5">{{ $trip->duration_days }} Hari</td>
                        <td class="px-6 py-5">{{ number_format($trip->distance_km, 0, ',', '.') }} KM</td>
                        <td class="px-6 py-5 font-semibold">{{ format_currency($trip->total_allowance_amount, $trip->currency) }}</td>
                        <td class="px-6 py-5"><x-badge :status="$trip->status" /></td>
                        <td class="px-6 py-5"><a href="{{ route('pegawai.perdin.show', $trip) }}" class="font-semibold text-primary">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="px-6 py-10 text-center text-slate-500">{{ $isHistory ? 'Belum ada riwayat pengajuan yang diproses.' : 'Belum ada pengajuan perjalanan dinas.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="border-t border-slate-200 px-6 py-4">{{ $trips->links() }}</div>
    </x-table>
</div>
@endsection
