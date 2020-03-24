<?php

return [
    'type' => 'route_entry',
    'name' => 'Route entry',
    'view' => 'test',
    'fields' => [
        [
            'key' => 'route_key',
            'type' => config('cms.fields.route_field_type'),
            'rules' => 'required',
            'label' => 'Route label',
        ],
    ],
];
