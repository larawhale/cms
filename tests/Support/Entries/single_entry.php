<?php

return [
    'type' => 'single_entry',
    'name' => 'Single entry',
    'view' => 'test',
    'single' => true,
    'fields' => [
        [
            'key' => 'test_key',
            'type' => 'test_type',
            'config' => [
                'rules' => 'required',
                'label' => 'Test label',
            ],
        ],
        [
            'key' => 'another_test_key',
            'type' => 'another_test_type',
            'config' => [
                'rules' => 'required',
                'label' => 'Another test label',
            ],
        ],
    ],
];
