@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-medium text-white bg-gray-900 transition-colors duration-200'
            : 'flex items-center px-4 py-3 text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-700 transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} :class="{'justify-center': isSidebarMinimized}">
    @if (isset($icon))
        <div class="w-6 text-center">{{ $icon }}</div>
    @endif
    
    <div class="flex-1 overflow-hidden whitespace-nowrap transition-all duration-200" :class="{'w-0 opacity-0': isSidebarMinimized, 'w-full opacity-100': !isSidebarMinimized}" >
        {{ $slot }}
    </div>
</a>