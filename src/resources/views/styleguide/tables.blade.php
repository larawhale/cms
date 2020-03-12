@component('cms::components.card')
    @slot('cardHeader')
        Tables
    @endslot

    @php
        $items = [
            [
                '#' => 0,
                'first' => 'Mark',
                'last' => 'Otto',
                'handle' => '@mdo',
            ],
            [
                '#' => 1,
                'first' => 'Jacob',
                'last' => 'Thornton',
                'handle' => '@fat',
            ],
            [
                '#' => 3,
                'first' => 'Larry',
                'last' => ' the Bird',
                'handle' => '@twitter',
            ],
        ];
    @endphp

    @include('cms::components.table', [
        'columns' => array_keys($items[0]),
        'items' => $items,
    ])
@endcomponent
