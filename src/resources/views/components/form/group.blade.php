@php
    // Type
    // -------------------- -->
    $type = $type ?? 'text';

    // TODO: The following default value assignments could be done in a view
    // composer.
    $options = $options ?? [];

    // Label
    // -------------------- -->
    $label = $label ?? $name;

    // List
    // -------------------- -->
    $list = $list ?? [];

    // Value
    // -------------------- -->
    $value = $value ?? null;

    // Label
    // -------------------- -->
    $label = $label ?? $name;

    $showLabel = $showLabel ?? true;

    // Id
    // -------------------- -->
    $options['id'] = $options['id'] ?? $name;

    // Placeholder
    // -------------------- -->
    $options['placeholder'] = $options['placeholder'] ?? $placeholder ?? null;

    // Class option
    // -------------------- -->
    $options['class'] = $options['class'] ?? '';

    // Form control
    if (! Str::contains($options['class'], 'form-control')) {
        $options['class'] .= ' form-control';
    }

    // Is invalid
    if (isset($errors) && $errors->has($name)) {
        $options['class'] .= ' is-invalid';
    }

    // Custom control
    if (in_array($type, [
        'checkbox', 'radio',
    ])) {
        $options['class'] .= ' custom-control-input';
    }
@endphp

<div class="form-group">
    @if ($showLabel && $type !== 'checkbox')
        {!! Form::label($options['id'], $label) !!}
    @endif

    @if (isset($input))
        {!! $input !!}
    @else
        @switch ($type)
            @case ('textarea')
                {!! Form::textarea($name, $value, $options) !!}
                @break

            @case ('select')
                {!! Form::select($name, $list, $value, $options) !!}
                @break

            @case ('checkbox')
            @case ('radio')
                <div class="custom-control custom-{{ $type }}">
                    {!! Form::$type($name, $value, null, $options) !!}

                    {!! Form::label($options['id'], $label, [
                        'class' => 'custom-control-label'
                    ]) !!}
                </div>
                @break

            @default
                {!! Form::input($type, $name, $value, $options) !!}
                @break
        @endswitch
    @endif

    @if (isset($helpText))
        <small>
            {!! $helpText !!}
        </small>
    @endif

    @if (isset($errors) && $errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div> 
