@props(['variant' => 'primary', 'type' => 'button'])

@php
    $classes = match ($variant) {
        'secondary' => 'border border-primary text-primary bg-white hover:bg-sky-50',
        'danger' => 'border border-red-500 text-red-600 bg-white hover:bg-red-50',
        default => 'bg-primary text-white hover:bg-sky-700',
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-semibold transition {$classes}"]) }}>
    {{ $slot }}
</button>
