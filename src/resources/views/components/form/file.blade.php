

{{-- This component is controlled by javascript in listeners.js --}}

@php
    $attributes['placeholder'] = $attributes['placeholder'] ?? __('cms::inputs.file.placeholder');
@endphp

<cms-file-input
    id="{{ $attributes['id'] }}"
    placeholder="{{ __('cms::inputs.file.placeholder') }}"
    value="{{ $value }}"
    name="{{ $name }}"
></cms-file-input>

