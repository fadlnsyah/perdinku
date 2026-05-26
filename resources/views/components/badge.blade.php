@props(['status' => 'pending'])

@php
    $label = match ($status) {
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        default => 'Pending',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 '.status_badge_classes($status)]) }}>
    {{ $label }}
</span>
