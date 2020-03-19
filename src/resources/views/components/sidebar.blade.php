@inject('Factory', 'LaraWhale\Cms\Library\Entries\Factory')

<aside class="sidebar bg-white">
    <h6>
        Entries
    </h6>

    <nav class="nav flex-column">
        @foreach ($Factory::entries() as $entry)
            @php
                $name = __($entry->name());

                $text = $entry->single()
                    ? $name
                    : Str::plural($name);
            @endphp

            <li class="nav-item">
                @include('cms::components.link', [
                    'route' => 'cms.entries.index',
                    'parameters' => [
                        'type' => $entry->type(),
                    ],
                    'class' => 'nav-link',
                    'slot' => $text,
                ])
            </li>
        @endforeach
    </nav>
</aside>
