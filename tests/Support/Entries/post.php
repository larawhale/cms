<?php

use LaraWhale\Cms\Models\User;

return [
    'type' => 'post',
    'name' => 'Post',
    'table_columns' => [
        'title', 'entry_model:created_at',
    ],
    'view' => 'cms::entries.examples.post',
    'fields' => [
        [
            'key' => 'route',
            'type' => config('cms.fields.route_field_type'),
            'config' => [
                'label' => 'Route',
                'rules' => 'required|string|max:191',
            ],
        ],
        [
            'key' => 'author',
            'type' => 'model_select',
            'config' => [
                'input_attributes' => [
                    'placeholder' => 'Select a user',
                ],
                'label' => 'Author',
                'list_item_label_key' => 'name',
                'model_class' => User::class,
                'rules' => 'required|numeric|exists:' . cms_table_name('users') . ',id',
            ],
        ],
        [
            'key' => 'title',
            'type' => 'text',
            'config' => [
                'label' => 'Title',
                'rules' => 'required|string|max:191',
            ],
        ],
        [
            'key' => 'body',
            'type' => 'textarea',
            'config' => [
                'label' => 'Body',
                'rules' => 'required|string|max:500',
            ],
        ],
    ],
];
