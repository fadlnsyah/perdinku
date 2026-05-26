@extends('layouts.app')

@php($pageTitle = 'Manajemen User')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Manajemen User</h1>
            <p class="mt-2 text-lg text-slate-600">Kelola akses dan perizinan personil perusahaan dalam satu tempat.</p>
        </div>
        <a href="{{ route('admin.users.create') }}"><x-button>Tambah User</x-button></a>
    </div>
    <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_220px]">
        <form method="GET"><input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Cari user..."></form>
        <form method="GET">
            <select name="role" onchange="this.form.submit()" class="form-control">
                <option value="">Semua Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected($selectedRole === $role)>{{ $role }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <x-card class="p-6"><p class="text-sm text-slate-500">Total Users</p><p class="mt-3 text-4xl font-bold">{{ $stats['total'] }}</p></x-card>
        <x-card class="p-6"><p class="text-sm text-slate-500">Active Users</p><p class="mt-3 text-4xl font-bold">{{ $stats['active'] }}</p></x-card>
    </div>
    <x-table>
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr class="text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    <th class="px-6 py-4">No</th><th class="px-6 py-4">Nama</th><th class="px-6 py-4">Username</th><th class="px-6 py-4">Role</th><th class="px-6 py-4">Status</th><th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($users as $user)
                    <tr class="text-sm text-slate-700">
                        <td class="px-6 py-5">{{ $loop->iteration }}</td>
                        <td class="px-6 py-5 font-semibold">{{ $user->name }}</td>
                        <td class="px-6 py-5">{{ $user->username }}</td>
                        <td class="px-6 py-5"><span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-primary">{{ $user->getRoleNames()->first() }}</span></td>
                        <td class="px-6 py-5">{{ $user->status === 'active' ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="px-6 py-5"><div class="flex gap-3"><a href="{{ route('admin.users.edit', $user) }}" class="font-semibold text-primary">Edit</a><form method="POST" action="{{ route('admin.users.destroy', $user) }}">@csrf @method('DELETE')<button class="font-semibold text-red-600">Hapus</button></form></div></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-slate-200 px-6 py-4">{{ $users->links() }}</div>
    </x-table>
</div>
@endsection
