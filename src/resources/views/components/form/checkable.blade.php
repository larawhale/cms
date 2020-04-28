<div class="custom-control custom-{{ $type }}">
    {!! Form::$type($name, $value, null, $options) !!}

    {!! Form::label($options['id'], $label, [
        'class' => 'custom-control-label'
    ]) !!}
</div>
