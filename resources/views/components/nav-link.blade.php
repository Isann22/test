@props(['active' => false])

@php
    $classes =
        $active ?? false
            ? 'text-black border-b-2 border-black pb-1 font-semibold'
            : 'text-gray-500 hover:text-black hover:border-b-2 hover:border-gray-300 pb-1 transition-all duration-200';
@endphp

<li class="inline-block mx-4">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
