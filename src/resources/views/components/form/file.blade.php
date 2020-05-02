{{-- This component is controlled by javascript in listeners.js --}}

@php
    $attributes['placeholder'] = $value
        ?: $attributes['placeholder']
        ?? __('cms::inputs.file.placeholder');
@endphp

<div class="custom-file">
    {!! Form::file($name, $attributes) !!}

    {!! Form::label(
        $attributes['id'],
        $attributes['placeholder'],
        ['class' => 'custom-file-label'],
    ) !!}
</div>
