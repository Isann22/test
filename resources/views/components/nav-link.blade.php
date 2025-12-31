@props(['active' => false])

@php
    // Logika untuk menentukan class styling
    $classes =
        $active ?? false
            ? 'active font-bold' // Class jika menu Aktif
            : ''; // Class jika menu Tidak Aktif
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
