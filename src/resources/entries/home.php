<?php

return [
    'type' => 'home',
    'name' => 'Home',
    'view' => 'entries.home',
    'single' => true,
    'fields' => [
        [
            'key' => 'route',
            'type' => config('cms.fields.route_field_type'),
            'rules' => 'required',
            'label' => 'Route',
        ],
        [
            'key' => 'title',
            'type' => 'text',
        ],
        [
            'key' => 'body',
            'type' => 'textarea',
        ],
    ],
];
