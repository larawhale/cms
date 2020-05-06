<?php

use LaraWhale\Cms\Models\User;

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
        [
            'key' => 'file',
            'type' => 'file',
        ],
        [
            'key' => 'model_select',
            'type' => 'model_select',
            'config' => [
                'input_attributes' => [
                    'placeholder' => 'Select a user',
                ],
                'list_item_label_key' => 'name',
                'model_class' => User::class,
                'query_constraint' => function ($query) {
                    $query->limit(15);
                },
            ],
        ],
        [
            'key' => 'entry_select',
            'type' => 'entry_select',
            'config' => [
                'type' => 'test_entry',
                'input_attributes' => [
                    'placeholder' => 'Select an entry',
                ],
                'list_item_label_key' => 'name',
                'query_constraint' => function ($query) {
                    $query->limit(15);
                },
            ],
        ],
    ],
];
