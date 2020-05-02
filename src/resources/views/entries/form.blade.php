@php
    $entryClass = $entry->toEntryClass();
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
