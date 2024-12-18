@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm']) }} style="color: white;">
    {{ $value ?? $slot }}
</label>
