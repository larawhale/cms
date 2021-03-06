<?php

return [
    'type' => 'another_test_entry',
    'name' => 'Another test entry',
    'view' => 'test',
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
