<div x-cloak {{ $attributes->merge(['class' => 'fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 px-4 backdrop-blur-sm']) }}>
    <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl">
        {{ $slot }}
    </div>
</div>
