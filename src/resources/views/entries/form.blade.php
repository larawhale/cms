{{-- TODO: Remove this and fix tests when this is not performant. --}}
@inject('Form', 'Collective\Html\FormFacade')

@php
    $entryClass = $entry->toEntryClass();

    $options = [];

    $options['method'] = $entry->exists ? 'put' : 'POST';

    $options['url'] = $entry->exists
        ? route('cms.entries.update', compact('entry'))
        : route('cms.entries.store');
@endphp

{!! $Form::open($options) !!}
    {!! $Form::input('hidden', 'entry_type', $entryClass->type()) !!}

    @foreach ($entryClass->fields() as $field)
        {!! $field->renderFormGroup() !!}
    @endforeach

    {!! $Form::submit(__('cms::actions.submit_form'), [
        'class' => 'btn btn-primary',
    ]) !!}
{!! $Form::close() !!}
