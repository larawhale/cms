<?php

use LaraWhale\Cms\Models\User;

return [
    'type' => 'all_types',
    'name' => 'All types',
    'view' => 'all_types',
    'single' => true,
    'fields' => [
        [
            'key' => 'fields',
            'type' => 'fields',
            'config' => [
                'fields' => [
                    [
                        'key' => 'field_1',
                        'type' => 'text',
                        'config' => [
                            'rules' => 'required|in:a,b',
                        ],
                    ],
                    [
                        'key' => 'field_2',
                        'type' => 'text',
                        'config' => [
                            'rules' => 'required',
                        ],
                    ],
                ],
            ],
        ],
        [
            'key' => 'route',
            'type' => config('cms.fields.route_field_type'),
        ],
        [
            'key' => 'text',
            'type' => 'text',
            'config' => [
                'rules' => 'required',
            ],
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
            'key' => 'multi_select',
            'type' => 'multi_select',
            'config' => [
                'input_attributes' => [
                    'placeholder' => 'Select items',
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
                'entry_type' => 'test_entry',
                'input_attributes' => [
                    'placeholder' => 'Select a test entry',
                ],
                'list_item_label_key' => 'test_key',
                'query_constraint' => function ($query) {
                    $query->limit(15);
                },
            ],
        ],
    ],
];
