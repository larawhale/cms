{{-- TODO: Remove this and fix tests when this is not performant. --}}
@inject('Form', 'Collective\Html\FormFacade')

<header class="nav justify-content-between bg-white px-3 py-2 border-bottom fixed-top">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cms.home') }}">
            cms
        </a>
    </li>

    <li class="nav-item">
        {!! $Form::open([
            'route' => 'cms.logout',
        ]) !!}
            {!! $Form::submit(__('cms::actions.submit'), [
                'class' => 'btn btn-link',
                'dusk' => 'submit-logout',
            ]) !!}
        {!! $Form::close() !!}
    </li>
</header>
