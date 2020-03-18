@extends('cms::layouts.auth')

@section('content')
    @component('cms::components.card')
        {!! Form::open([
            'route' => 'cms.login',
        ]) !!}
            @include('cms::components.form.group', [
                'label' => __('cms::inputs.email.label'),
                'placeholder' => __('cms::inputs.email.placeholder'),
                'name' => 'email',
                'type' => 'email',
            ])

            @include('cms::components.form.group', [
                'label' => __('cms::inputs.password.label'),
                'placeholder' => __('cms::inputs.password.placeholder'),
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

