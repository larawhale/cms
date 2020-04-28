<header class="px-3 fixed-top bg-light">
    <nav class="nav justify-content-between py-2 border-bottom">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cms.home') }}">
                cms
            </a>
        </li>

        <li class="nav-item">
            {!! Form::open([
                'route' => 'cms.logout',
            ]) !!}
                {!! Form::submit(__('cms::actions.logout'), [
                    'class' => 'btn btn-link',
                    'dusk' => 'submit-logout',
                ]) !!}
            {!! Form::close() !!}
        </li>
    </nav>
</header>
