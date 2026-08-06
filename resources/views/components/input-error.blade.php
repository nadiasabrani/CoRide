@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-xs space-y-1 mt-1.5']) }} style="color:#FC8181; font-family:'IBM Plex Mono', monospace;">
        @foreach ((array) $messages as $message)
            <li>⚠ {{ $message }}</li>
        @endforeach
    </ul>
@endif
