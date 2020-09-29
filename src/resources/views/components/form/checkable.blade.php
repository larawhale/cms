@php
    $inline = $inline ?? false;

    $checked = $checked ?? $value === 'on';
@endphp

<div class="custom-control custom-{{ $type }} {{ $inline ? 'custom-control-inline' : '' }}">
    {!! Form::$type($name, $value, $checked, $attributes) !!}

    {!! Form::label($attributes['id'], $label, [
        'class' => 'custom-control-label'
    ]) !!}
</div>
