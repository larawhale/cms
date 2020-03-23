@php
    $layout = Auth::check() ? 'cms::layouts.default' : 'cms::layouts.auth';
@endphp

@extends($layout)

@section('content')
    <div class="text-center">
        <h1 class="display-1">
            {{ $status }}
        </h1>

        <p>
            {{ $message ?? __("cms::errors.http.$status") }}
        </p>
    </div>
@endsection
