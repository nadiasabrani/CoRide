@props(['active'])

@php
$classes = ($active ?? false)
    ? 'nav-link-dark active'
    : 'nav-link-dark';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
