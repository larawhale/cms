{{-- TODO: Remove this and fix tests when this is not performant. --}}
@inject('Form', 'Collective\Html\FormFacade')

@php
    $name = $name ?? '';

    $label = $label ?? $name;

    $type = $type ?? 'text';
@endphp

<div class="form-group">
    {!! $Form::label($name, $label) !!}

    @if (isset($input))
        {!! $input !!}
    @else
        {!! $Form::input($type, $name, null, [
            'class' => 'form-control',
        ]) !!}
    @endif
</div>
