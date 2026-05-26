@extends('layouts.app')

@php($pageTitle = 'Buat Pengajuan Perjalanan Dinas')

@section('content')
<div class="space-y-8" x-data="tripEstimator()">
    <div>
        <h1 class="text-4xl font-bold tracking-tight text-slate-900">Buat Pengajuan Perjalanan Dinas</h1>
        <p class="mt-2 text-lg text-slate-600">Lengkapi formulir di bawah ini untuk mengajukan perjalanan dinas baru.</p>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <x-card class="p-8">
            <form method="POST" action="{{ route('pegawai.perdin.store') }}" class="space-y-6">
                @csrf
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Kota Asal</label>
                        <select name="origin_city_id" x-model="form.origin_city_id" @change="estimate" class="form-control">
                            <option value="">Pilih Kota Asal</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @selected(old('origin_city_id') == $city->id)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('origin_city_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Kota Tujuan</label>
                        <select name="destination_city_id" x-model="form.destination_city_id" @change="estimate" class="form-control">
                            <option value="">Pilih Kota Tujuan</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @selected(old('destination_city_id') == $city->id)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('destination_city_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Berangkat</label>
                        <input type="date" name="start_date" x-model="form.start_date" @change="estimate" value="{{ old('start_date') }}" class="form-control">
                        @error('start_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Pulang</label>
                        <input type="date" name="end_date" x-model="form.end_date" @change="estimate" value="{{ old('end_date') }}" class="form-control">
                        @error('end_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Maksud Tujuan / Keterangan</label>
                    <textarea name="purpose" rows="6" x-model="form.purpose" class="form-control">{{ old('purpose') }}</textarea>
                    @error('purpose')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('pegawai.perdin.index') }}"><x-button variant="secondary">Batal</x-button></a>
                    <x-button type="submit" x-bind:disabled="!canSubmit">Ajukan Perdin</x-button>
                </div>
            </form>
        </x-card>

        <div class="space-y-4">
            <div class="overflow-hidden rounded-[28px] bg-primary text-white shadow-xl shadow-sky-500/20">
                <div class="p-8">
                    <h2 class="text-3xl font-bold">Ringkasan Estimasi</h2>
                    <div class="mt-6 space-y-4 text-sm">
                        <div class="flex items-center justify-between"><span>Total Hari</span><span class="text-2xl font-bold" x-text="summary.duration_days + ' Hari'"></span></div>
                        <div class="flex items-center justify-between"><span>Estimasi Jarak</span><span class="text-2xl font-bold" x-text="Math.round(summary.distance_km) + ' KM'"></span></div>
                        <div class="flex items-center justify-between"><span>Klasifikasi</span><span class="rounded-full bg-white/15 px-3 py-1 font-semibold" x-text="summary.classification"></span></div>
                        <div class="border-t border-white/20 pt-4">
                            <p>Rate Harian</p>
                            <p class="mt-2 text-2xl font-bold" x-text="formatMoney(summary.daily_allowance_amount, summary.currency)"></p>
                        </div>
                        <div>
                            <p>Estimasi Uang Saku</p>
                            <p class="mt-2 text-4xl font-bold" x-text="formatMoney(summary.total_allowance_amount, summary.currency)"></p>
                        </div>
                    </div>
                </div>
            </div>
            <x-card class="p-6 text-sm leading-7 text-slate-600">
                Pastikan seluruh data yang diinput sudah benar sesuai instruksi atasan. Estimasi ini akan digunakan sebagai dasar nominal pengajuan.
            </x-card>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function tripEstimator() {
        return {
            form: {
                origin_city_id: '{{ old('origin_city_id') }}',
                destination_city_id: '{{ old('destination_city_id') }}',
                start_date: '{{ old('start_date') }}',
                end_date: '{{ old('end_date') }}',
                purpose: @js(old('purpose', '')),
            },
            summary: {
                duration_days: 0,
                distance_km: 0,
                classification: 'Belum tersedia',
                daily_allowance_amount: 0,
                currency: 'IDR',
                total_allowance_amount: 0,
            },
            get canSubmit() {
                return this.form.origin_city_id && this.form.destination_city_id && this.form.start_date && this.form.end_date && this.form.purpose.length >= 10;
            },
            async estimate() {
                if (!this.form.origin_city_id || !this.form.destination_city_id || !this.form.start_date || !this.form.end_date) return;
                const response = await fetch('{{ route('pegawai.perdin.estimate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });
                if (!response.ok) return;
                this.summary = await response.json();
            },
            formatMoney(amount, currency) {
                return (currency === 'USD' ? 'USD ' : 'Rp ') + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(amount ?? 0);
            },
            init() {
                this.estimate();
            }
        }
    }
</script>
@endpush
