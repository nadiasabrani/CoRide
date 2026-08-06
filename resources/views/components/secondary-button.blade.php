<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-pro-primary bg-gray-700 hover:bg-gray-600 focus:ring-gray-500 border border-[var(--border-color)]']) }}>
    {{ $slot }}
</button>
