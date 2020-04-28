<?php

return [
    'type' => 'all_types',
    'name' => 'All types',
    'view' => 'entries.all_types',
    'single' => true,
    'fields' => [
        [
            'key' => 'route',
            'type' => config('cms.fields.route_field_type'),
        ],
        [
            'key' => 'text',
            'type' => 'text',
        ],
        [
            'key' => 'textarea',
            'type' => 'textarea',
        ],
        [
            'key' => 'checkbox',
            'type' => 'checkbox',
        ],
        [
            'key' => 'radio',
            'type' => 'radio',
        ],
        [
            'key' => 'select',
            'type' => 'select',
            'config' => [
                'input_attributes' => [
                    'placeholder' => 'Select an item',
                ],
                'list' => [
                    'item 1',
                    'item 2',
                    'item 3',
                ],
            ],
        ],
    ],
];
