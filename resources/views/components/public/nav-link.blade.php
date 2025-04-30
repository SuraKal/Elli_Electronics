@props(['active'])

@php
$classes = ($active ?? false)
            ? 'megamenu-container active'
            : 'megamenu-container';
@endphp

{{-- <a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> --}}

<li {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</li>
