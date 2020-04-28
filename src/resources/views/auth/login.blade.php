@extends('cms::layouts.auth')

@section('content')
    @component('cms::components.card')
        {!! Form::open([
            'route' => 'cms.login',
        ]) !!}
            @include('cms::components.form.group', [
                'label' => __('cms::inputs.email.label'),
                'name' => 'email',
                'placeholder' => __('cms::inputs.email.placeholder'),
                'type' => 'email',
            ])

            @include('cms::components.form.group', [
                'label' => __('cms::inputs.password.label'),
                'name' => 'password',
                'placeholder' => __('cms::inputs.password.placeholder'),
                'type' => 'password',
            ])

            @include('cms::components.form.group', [
                'label' => __('cms::inputs.remember.label'),
                'name' => 'remember',
                'type' => 'checkbox',
            ])

            {!! Form::submit(__('cms::actions.login'), [
                'class' => 'btn btn-primary btn-block',
                'dusk' => 'submit-login',
            ]) !!}
        {!! Form::close() !!}
    @endcomponent
@endsection
