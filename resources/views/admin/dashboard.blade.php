@extends('layouts.app')

@php($pageTitle = 'Dashboard Admin')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-4xl font-bold tracking-tight">Dashboard Admin</h1>
        <p class="mt-2 text-lg text-slate-600">Ringkasan operasional user, kota, dan pengajuan perjalanan dinas.</p>
    </div>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <x-card class="p-6"><p class="text-sm text-slate-500">Total Kota</p><p class="mt-3 text-4xl font-bold">{{ $stats['cities'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm text-slate-500">Luar Negeri</p><p class="mt-3 text-4xl font-bold">{{ $stats['foreign_cities'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm text-slate-500">Total User</p><p class="mt-3 text-4xl font-bold">{{ $stats['users'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm text-slate-500">User Aktif</p><p class="mt-3 text-4xl font-bold">{{ $stats['active_users'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm text-slate-500">Pending</p><p class="mt-3 text-4xl font-bold">{{ $stats['pending_trips'] }}</p></x-card>
    </div>
    <x-table>
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    <th class="px-6 py-4">Trip</th>
                    <th class="px-6 py-4">Pegawai</th>
                    <th class="px-6 py-4">Rute</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($latestTrips as $trip)
                    <tr class="text-sm text-slate-700">
                        <td class="px-6 py-5 font-semibold">{{ $trip->trip_number }}</td>
                        <td class="px-6 py-5">{{ $trip->user->name }}</td>
                        <td class="px-6 py-5">{{ $trip->originCity->name }} → {{ $trip->destinationCity->name }}</td>
                        <td class="px-6 py-5"><x-badge :status="$trip->status" /></td>
                        <td class="px-6 py-5">{{ format_currency($trip->total_allowance_amount, $trip->currency) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-table>
</div>
@endsection
