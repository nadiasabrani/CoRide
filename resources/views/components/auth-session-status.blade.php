@props(['status'])

@if ($status)
    <div {{ $attributes }} class="alert-success">
        ✓ {{ $status }}
    </div>
@endif
