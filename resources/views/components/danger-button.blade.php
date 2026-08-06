<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-pro-primary bg-red-600 hover:bg-red-500 focus:ring-red-500 shadow-red-500/20']) }}>
    {{ $slot }}
</button>
