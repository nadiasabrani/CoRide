@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-[var(--text-muted)] mb-1.5 uppercase tracking-wider']) }}>
    {{ $value ?? $slot }}
</label>
