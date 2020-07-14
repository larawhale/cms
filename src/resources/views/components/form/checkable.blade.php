@php
    $inline = $inline ?? false;
@endphp

<div class="custom-control custom-{{ $type }} {{ $inline ? 'custom-control-inline' : '' }}">
    {!! Form::$type($name, $value, $checked ?? null, $attributes) !!}

    {!! Form::label($attributes['id'], $label, [
        'class' => 'custom-control-label'
    ]) !!}
</div>
