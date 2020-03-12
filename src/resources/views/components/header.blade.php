<header class="nav justify-content-between bg-white px-3 py-2 border-bottom fixed-top">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cms.home') }}">
            cms
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('cms.logout') }}">
            {!! __('cms::actions.logout') !!}
        </a>
    </li>
</header>
