@php
    $attributes['placeholder'] = $attributes['placeholder']
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
