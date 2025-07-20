<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-secondary btn-md']) }}>
    {{ $slot }}
</button>
