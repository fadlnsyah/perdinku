<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/85 backdrop-blur">
    <div class="flex items-center justify-between gap-6 px-6 py-4 xl:px-10">
        <div class="flex-1">
            <div class="max-w-xl rounded-full border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                Cari perjalanan, kota, user, atau status...
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden text-right md:block">
                <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">{{ auth()->user()->getRoleNames()->first() }}</p>
            </div>
            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-sky-100 text-sm font-bold text-primary">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
        </div>
    </div>
</header>
