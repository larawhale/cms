@php
    $entryClass = $entry->toEntryClass();

    $options = [];

    $options['method'] = $entry->exists ? 'patch' : 'post';

    $options['url'] = $entry->exists
        ? route('cms.entries.update', compact('entry'))
        : route('cms.entries.store');
@endphp

{!! Form::open($options) !!}
    {!! Form::input('hidden', 'entry_type', $entryClass->type()) !!}

    @foreach ($entryClass->fields() as $field)
        {!! $field->renderFormGroup() !!}
    @endforeach

    {!! Form::submit(__('cms::actions.submit'), [
        'class' => 'btn btn-primary',
        'dusk' => 'submit-entry',
    ]) !!}
{!! Form::close() !!}
