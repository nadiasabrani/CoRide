@props(['active'])

@php
$classes = ($active ?? false)
    ? 'nav-link-dark active block w-full'
    : 'nav-link-dark block w-full';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
