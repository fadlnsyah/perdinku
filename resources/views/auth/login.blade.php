@extends('layouts.guest')

@section('content')
<div class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">
        <div class="mb-10 text-center">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-[28px] bg-primary text-white shadow-xl shadow-sky-500/20">
                <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 18h20"/>
                    <path d="m3 8 6 3 3-7 9 8-4 2"/>
                </svg>
            </div>
            <h1 class="mt-6 text-5xl font-bold text-primary">PerdinKu</h1>
            <p class="mt-3 text-xl text-slate-700">Enterprise Travel Management System</p>
        </div>

        <div class="surface-card rounded-[28px] p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold uppercase tracking-[0.18em] text-slate-700">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" class="form-control rounded-2xl py-4 text-base" placeholder="Masukkan username Anda">
                    @error('username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <label class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-700">Password</label>
                        <a href="#" class="text-sm font-semibold text-primary">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" class="form-control rounded-2xl py-4 text-base" placeholder="Masukkan password Anda">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary focus:ring-primary">
                    Ingat saya di perangkat ini
                </label>

                <button type="submit" class="w-full rounded-2xl bg-primary px-5 py-4 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:bg-sky-700">
                    Masuk
                </button>
            </form>

            <div class="mt-8 border-t border-slate-200 pt-8 text-center text-sm text-slate-600">
                Belum memiliki akses? <span class="font-semibold text-primary">Hubungi Admin HR</span>
            </div>
        </div>

        <p class="mt-8 text-center text-sm text-slate-500">© 2026 PerdinKu Enterprise. Seluruh hak cipta dilindungi.</p>
    </div>
</div>
@endsection
