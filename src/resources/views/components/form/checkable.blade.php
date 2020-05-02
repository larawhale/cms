<div class="custom-control custom-{{ $type }}">
    {!! Form::$type($name, $value, null, $attributes) !!}

    {!! Form::label($attributes['id'], $label, [
        'class' => 'custom-control-label'
    ]) !!}
</div>
