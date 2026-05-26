@extends('layouts.app')

@php($pageTitle = 'Tambah User')

@section('content')
<div class="mx-auto max-w-3xl">
    <x-card class="p-8">
        <h1 class="text-3xl font-bold">Tambah User</h1>
        <form method="POST" action="{{ route('admin.users.store') }}" class="mt-8 space-y-6">
            @csrf
            <x-input name="name" label="Nama" :value="old('name')" />
            <x-input name="username" label="Username" :value="old('username')" />
            <div class="grid gap-6 md:grid-cols-2">
                <x-input name="password" type="password" label="Password" />
                <x-input name="password_confirmation" type="password" label="Konfirmasi Password" />
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div><label class="mb-2 block text-sm font-semibold">Role</label><select name="role" class="form-control">@foreach ($roles as $role)<option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>@endforeach</select>@error('role')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                <div><label class="mb-2 block text-sm font-semibold">Status</label><select name="status" class="form-control"><option value="active">Aktif</option><option value="inactive" @selected(old('status') === 'inactive')>Nonaktif</option></select></div>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}"><x-button variant="secondary">Batal</x-button></a>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
