@extends('layouts.app')

@php($pageTitle = 'Master Kota')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Master Kota</h1>
            <p class="mt-2 text-lg text-slate-600">Kelola data daftar kota operasional untuk perjalanan dinas.</p>
        </div>
        <a href="{{ route('admin.cities.create') }}"><x-button>Tambah Kota</x-button></a>
    </div>
    <form method="GET" class="max-w-md">
        <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Cari kota atau provinsi...">
    </form>
    <x-table>
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    <th class="px-6 py-4">No</th><th class="px-6 py-4">Nama Kota</th><th class="px-6 py-4">Provinsi</th><th class="px-6 py-4">Pulau</th><th class="px-6 py-4">Luar Negeri</th><th class="px-6 py-4">Latitude</th><th class="px-6 py-4">Longitude</th><th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($cities as $city)
                    <tr class="text-sm text-slate-700">
                        <td class="px-6 py-5">{{ $loop->iteration }}</td>
                        <td class="px-6 py-5 font-semibold text-primary">{{ $city->name }}</td>
                        <td class="px-6 py-5">{{ $city->province ?? '-' }}</td>
                        <td class="px-6 py-5">{{ $city->island ?? '-' }}</td>
                        <td class="px-6 py-5">{{ $city->is_foreign ? 'YA' : 'TIDAK' }}</td>
                        <td class="px-6 py-5">{{ $city->latitude }}</td>
                        <td class="px-6 py-5">{{ $city->longitude }}</td>
                        <td class="px-6 py-5">
                            <div class="flex gap-3">
                                <a href="{{ route('admin.cities.edit', $city) }}" class="font-semibold text-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.cities.destroy', $city) }}">@csrf @method('DELETE')<button class="font-semibold text-red-600">Hapus</button></form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-slate-200 px-6 py-4">{{ $cities->links() }}</div>
    </x-table>
    <div class="grid gap-4 md:grid-cols-3">
        <x-card class="p-6"><p class="text-sm text-slate-500">Total Kota Aktif</p><p class="mt-3 text-4xl font-bold">{{ $stats['total'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm text-slate-500">Provinsi Terdaftar</p><p class="mt-3 text-4xl font-bold">{{ $stats['provinces'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm text-slate-500">Destinasi Luar Negeri</p><p class="mt-3 text-4xl font-bold">{{ $stats['foreign'] }}</p></x-card>
    </div>
</div>
@endsection
