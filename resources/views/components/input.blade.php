@props(['label' => null, 'name'])

<label class="block space-y-2">
    @if ($label)
        <span class="text-sm font-semibold text-slate-700">{{ $label }}</span>
    @endif
    <input name="{{ $name }}" {{ $attributes->merge(['class' => 'form-control']) }}>
    @error($name)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</label>
