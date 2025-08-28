@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-4 py-2 text-sm font-medium text-white bg-gray-700'
            : 'block px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>