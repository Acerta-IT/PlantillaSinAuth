@props(['type' => 'primary', 'text' => 'white', 'hover' => '{{ $type }}4'])

<a
    {{ $attributes->merge(['class' => "px-4 py-2 inline-flex items-center bg-{$type} text-{$text} border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-{$type}4 hover:text-white focus:outline-none focus:ring-2 focus:ring-{$type} focus:ring-offset-2 transition ease-in-out duration-150 select-none cursor-pointer"]) }}>
    {{ $slot }}
</a>
