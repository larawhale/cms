@extends('cms::layouts.auth')

@section('content')
    @component('cms::components.card')
        {!! Form::open([
            'route' => 'cms.login',
        ]) !!}
            @include('cms::components.form.group', [
                'name' => 'email',
                'type' => 'email',
            ])

            @include('cms::components.form.group', [
                'name' => 'password',
                'type' => 'password',
            ])

            {!! Form::submit(__('cms::actions.login'), [
                'class' => 'btn btn-primary',
                'dusk' => 'submit-login',
            ]) !!}
        {!! Form::close() !!}
    @endcomponent
@endsection

