@extends('layouts.app')

@php($pageTitle = 'Edit Kota')

@section('content')
<div class="mx-auto max-w-3xl">
    <x-card class="p-8" x-data="{ foreign: {{ old('is_foreign', $city->is_foreign) ? 'true' : 'false' }} }">
        <h1 class="text-3xl font-bold">Edit Kota</h1>
        <form method="POST" action="{{ route('admin.cities.update', $city) }}" class="mt-8 space-y-6">
            @csrf @method('PUT')
            <x-input name="name" label="Nama Kota" :value="old('name', $city->name)" />
            <div class="grid gap-6 md:grid-cols-2">
                <div><label class="mb-2 block text-sm font-semibold">Provinsi</label><input type="text" name="province" value="{{ old('province', $city->province) }}" class="form-control" x-bind:disabled="foreign">@error('province')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                <div><label class="mb-2 block text-sm font-semibold">Pulau</label><input type="text" name="island" value="{{ old('island', $city->island) }}" class="form-control" x-bind:disabled="foreign">@error('island')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            </div>
            <label class="flex items-center justify-between rounded-2xl border border-dashed border-slate-300 px-4 py-4">
                <span><span class="block text-sm font-semibold">Luar Negeri</span><span class="text-sm text-slate-500">Aktifkan jika kota berada di luar wilayah Indonesia</span></span>
                <input type="hidden" name="is_foreign" :value="foreign ? 1 : 0">
                <button type="button" class="h-8 w-14 rounded-full bg-slate-200 p-1 transition" :class="foreign ? 'bg-primary' : 'bg-slate-200'" @click="foreign = !foreign"><span class="block h-6 w-6 rounded-full bg-white transition" :class="foreign ? 'translate-x-6' : ''"></span></button>
            </label>
            <div class="grid gap-6 md:grid-cols-2">
                <x-input name="latitude" label="Latitude" :value="old('latitude', $city->latitude)" />
                <x-input name="longitude" label="Longitude" :value="old('longitude', $city->longitude)" />
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.cities.index') }}"><x-button variant="secondary">Batal</x-button></a>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
