<?php

return [
    'type' => 'home',
    'name' => 'Home',
    'view' => 'cms::entries.examples.home',
    'single' => true,
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
