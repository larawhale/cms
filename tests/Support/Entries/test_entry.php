<?php

return [
    'type' => 'test_entry',
    'name' => 'Test entry',
    'view' => 'test',
    'table_columns' => [
        'entry_model:id',
        'test_key',
        'another_test_key',
        'entry_model:updated_at',
    ],
    'fields' => [
        [
            'key' => 'test_key',
            'type' => 'test_type',
            'rules' => 'required',
            'label' => 'Test label',
        ],
        [
            'key' => 'another_test_key',
            'type' => 'another_test_type',
            'rules' => 'required',
            'label' => 'Another test label',
        ],
    ],
];
