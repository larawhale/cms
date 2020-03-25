@inject('Factory', 'LaraWhale\Cms\Library\Entries\Factory')

<aside class="sidebar bg-light py-3">
    <div class="h-100 p-3 border-right">
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
    </div>
</aside>
