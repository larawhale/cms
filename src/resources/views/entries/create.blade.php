@extends('cms::layouts.default')

@section('content')
    <div class="mb-3">
        <h1 class="m-0">
            {{ __('cms::entries.create.title', [
                'type' => $entry->type,
            ]) }}
        </h1>
    </div>

    @component('cms::components.card')
        {!! $entry->toEntryClass()->renderForm() !!}
    @endcomponent
@endsection
