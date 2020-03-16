@extends('cms::layouts.default')

@section('content')
    @php
        $type = request('type');
    @endphp

    <div class="mb-3 clearfix">
        <h1 class="m-0 float-left">
            {{ __('cms::entries.index.title', [
                'name' => $entryClass->name(),
            ]) }}
        </h1>

        <a
            class="btn btn-primary float-right"
            href="{{ route('cms.entries.create', [
                'type' => $entryClass->type(),
            ]) }}"
        >
            {!! __('cms::actions.create') !!}
        </a>    
    </div>

    @component('cms::components.card')
        @if ($entries->isEmpty())
            <div class="p-3">
                {{ __('cms::entries.index.empty', [
                    'name' =>  $entryClass->name(),
                ]) }}
            </div>
        @else
            @include('cms::entries.table', [
                'columns' => ['id', 'type', 'updated_at', 'created_at'],
                'items' => $entries,
            ])
        @endif
    @endcomponent
@endsection
