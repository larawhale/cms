@extends('cms::layouts.default')

@section('content')
    <h1>
        Styleguide
    </h1>

    <hr>

    @include('cms::styleguide.typograpghy')

    <hr>

    @include('cms::styleguide.tables')

    <hr>

    @include('cms::styleguide.buttons')

    <hr>

    @include('cms::styleguide.cards')

    <hr>

    @include('cms::styleguide.form')

    <hr>

    @include('cms::styleguide.pagination')
@endsection
