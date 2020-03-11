{{-- TODO: Remove this and fix tests when this is not performant. --}}
@inject('Form', 'Collective\Html\FormFacade')

{!! $Form::open([
    'method' => 'post',
]) !!}
    @include('cms::components.form.group', [
        'label' => __('cms::inputs.email.label'),
        'name' => 'email',
        'type' => 'email',
    ])

    @include('cms::components.form.group', [
        'label' => __('cms::inputs.password.label'),
        'name' => 'password',
        'type' => 'password',
    ])

    {!! $Form::submit(__('cms::actions.submit_login'), [
        'class' => 'btn btn-primary',
        'dusk' => 'submit-login',
    ]) !!}
{!! $Form::close() !!}
