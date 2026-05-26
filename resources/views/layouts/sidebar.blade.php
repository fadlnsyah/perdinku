@php
    $user = auth()->user();
    $items = [];

    if ($user->hasRole('ADMIN')) {
        $items = [
            ['label' => 'Beranda', 'route' => route('admin.dashboard')],
            ['label' => 'Master Kota', 'route' => route('admin.cities.index')],
            ['label' => 'Manajemen User', 'route' => route('admin.users.index')],
        ];
    } elseif ($user->hasRole('SDM')) {
        $items = [
            ['label' => 'Pengajuan Perdin', 'route' => route('sdm.pengajuan.index'), 'active' => request()->routeIs('sdm.pengajuan.index') || request()->routeIs('sdm.pengajuan.show')],
        ];
    } else {
        $items = [
            ['label' => 'Pengajuan Perdin', 'route' => route('pegawai.perdin.index'), 'active' => request()->routeIs('pegawai.perdin.index') || request()->routeIs('pegawai.perdin.create') || request()->routeIs('pegawai.perdin.show')],
        ];
    }
@endphp

<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 border-r border-slate-200 bg-white/95 px-5 py-8 backdrop-blur xl:block">
    <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-white shadow-lg shadow-sky-500/20">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M2 18h20"/>
                <path d="m3 8 6 3 3-7 9 8-4 2"/>
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-primary">PerdinKu</p>
            <p class="text-xs uppercase tracking-[0.32em] text-slate-500">Enterprise Travel</p>
        </div>
    </div>

    <nav class="mt-10 space-y-2">
        @foreach ($items as $item)
            @php $active = $item['active'] ?? (request()->fullUrlIs($item['route'].'*') || request()->url() === $item['route']); @endphp
            <a href="{{ $item['route'] }}" class="{{ $active ? 'bg-sky-50 text-primary ring-1 ring-sky-100' : 'text-slate-700 hover:bg-slate-50' }} flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition">
                <span class="h-2 w-2 rounded-full {{ $active ? 'bg-primary' : 'bg-slate-300' }}"></span>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="absolute bottom-8 left-5 right-5">
        @csrf
        <button class="flex items-center gap-3 text-sm font-semibold text-red-600">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <path d="m16 17 5-5-5-5"/>
                <path d="M21 12H9"/>
            </svg>
            Logout
        </button>
    </form>
</aside>
