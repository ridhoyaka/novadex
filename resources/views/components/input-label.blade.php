@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-arsa-200']) }}>
    {{ $value ?? $slot }}
</label>
