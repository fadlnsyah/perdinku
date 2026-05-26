<?php

if (! function_exists('format_currency')) {
    function format_currency(float|int|null $amount, string $currency = 'IDR'): string
    {
        $amount ??= 0;

        if ($currency === 'USD') {
            return 'USD '.number_format($amount, 0, ',', '.');
        }

        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}

if (! function_exists('status_badge_classes')) {
    function status_badge_classes(string $status): string
    {
        return match ($status) {
            'approved' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'rejected' => 'bg-red-100 text-red-700 ring-red-200',
            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
            default => 'bg-slate-100 text-slate-700 ring-slate-200',
        };
    }
}
