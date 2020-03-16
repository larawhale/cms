@php
    $parameters = $parameters ?? [];
@endphp

<a
    href="{{ route($route, $parameters) }}"
    class="{{ $class ?? '' }} {{ is_current_route($route, $parameters) ? 'active' : '' }}"
>
    {{ $slot }}
</a>
