@extends('cms::layouts.default')

{{-- TODO: Remove this and fix tests when this is not performant. --}}
@inject('Form', 'Collective\Html\FormFacade')

@section('content')
    <div class="mb-3 clearfix">
        <h1 class="m-0 float-left">
            {{ __('cms::entries.edit.title', [
                'type' => $entry->type,
            ]) }}
        </h1>

        {!! $Form::open([
            'class' => 'float-right',
            'method' => 'DELETE',
            'url' => route('cms.entries.destroy', compact('entry')),
        ]) !!}
            <input
                class="btn btn-danger action-confirm"
                type="submit"
                value="{{ __('cms::actions.delete') }}"
            >
        {!! $Form::close() !!}
    </div>

    @component('cms::components.card')
        {!! $entry->toEntryClass()->renderForm() !!}
    @endcomponent
@endsection
