<aside class="sidebar bg-white">
    <h6>
        Entries
    </h6>

    <nav class="nav flex-column">
        {{-- @foreach ($entry_types as $type)
            <li class="nav-item">
                @include('cms::components.link', [
                    'route' => 'cms.entries.index',
                    'parameters' => [
                        'type' => $type,
                    ],
                    'class' => 'nav-link',
                    'slot' => $type,
                ])
            </li>
        @endforeach --}}
    </nav>
</aside>
