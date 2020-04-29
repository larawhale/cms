@php
    $entryClass = $entry->toEntryClass();

    $attributes = $attributes ?? [];

    $attributes['method'] = $entry->exists ? 'patch' : 'post';

    $attributes['url'] = $entry->exists
        ? route('cms.entries.update', compact('entry'))
        : route('cms.entries.store');
@endphp

{!! Form::open($attributes) !!}
    {!! Form::input('hidden', 'entry_type', $entryClass->getType()) !!}

    @foreach ($entryClass->getFields() as $field)
        {!! $field->renderFormGroup() !!}
    @endforeach

    {!! Form::submit(__('cms::actions.submit'), [
        'class' => 'btn btn-primary',
        'dusk' => 'submit-entry',
    ]) !!}
{!! Form::close() !!}
