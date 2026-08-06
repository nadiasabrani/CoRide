<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-pro-primary']) }}>
    {{ $slot }}
</button>
