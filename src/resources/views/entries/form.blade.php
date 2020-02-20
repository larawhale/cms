{{-- TODO: Remove this and fix tests when this is not performant. --}}
@inject('Form', 'Collective\Html\FormFacade')

{!! $Form::open() !!}
    {!! $Form::input('hidden', 'entry_key', $entry->key()) !!}

    @foreach ($entry->fields() as $field)
        {!! $field->renderFormGroup() !!}
    @endforeach
{!! $Form::close() !!}
