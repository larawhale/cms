<?php

return [
    'type' => 'test_entry',
    'name' => 'Test entry',
    'view' => 'test',
    'fields' => [
        [
            'key' => 'test_key',
            'type' => 'test_type',
            'rules' => 'required',
            'label' => 'test_label',
        ],
        [
            'key' => 'another_test_key',
            'type' => 'another_test_type',
            'rules' => 'required',
            'label' => 'another_test_label',
        ],
    ],
];
