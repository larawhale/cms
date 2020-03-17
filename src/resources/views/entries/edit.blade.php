@extends('cms::layouts.default')

@php
    $entryClass = $entry->toEntryClass();
@endphp

@section('content')
    <div class="mb-3 clearfix">
        <h1 class="m-0 float-left">
            {{ __('cms::entries.edit.title', [
                'name' => $entryClass->name(),
            ]) }}
        </h1>

        {!! Form::open([
            'class' => 'float-right',
            'method' => 'DELETE',
            'url' => route('cms.entries.destroy', compact('entry')),
        ]) !!}
            <input
                class="btn btn-danger action-confirm"
                type="submit"
                value="{{ __('cms::actions.delete') }}"
            >
        {!! Form::close() !!}
    </div>

    @component('cms::components.card')
        {!! $entryClass->renderForm() !!}
    @endcomponent
@endsection
