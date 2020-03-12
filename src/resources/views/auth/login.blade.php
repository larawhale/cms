@extends('cms::layouts.auth')

{{-- TODO: Remove this and fix tests when this is not performant. --}}
@inject('Form', 'Collective\Html\FormFacade')

@section('content')
    @component('cms::components.card')
        {!! $Form::open([
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

            {!! $Form::submit(__('cms::actions.submit_login'), [
                'class' => 'btn btn-primary',
                'dusk' => 'submit-login',
            ]) !!}
        {!! $Form::close() !!}
    @endcomponent
@endsection

