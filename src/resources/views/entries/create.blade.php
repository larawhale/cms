@extends('cms::layouts.default')

@php
    $entryClass = $entry->toEntryClass();
@endphp

@section('content')
    <div class="mb-3">
        <h1 class="m-0">
            {{ __('cms::entries.create.title', [
                'name' => $entryClass->getName(),
            ]) }}
        </h1>
    </div>

    @component('cms::components.card')
        {!! $entryClass->renderForm() !!}
    @endcomponent
@endsection
