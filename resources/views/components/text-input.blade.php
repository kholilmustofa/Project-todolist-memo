@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input input-neutral bg-neutral-800 focus:border-primary focus:outline-none hover:border-primary']) }}>
