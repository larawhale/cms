<?php

use LaraWhale\Cms\Models\User;

return [
    'type' => 'all_types',
    'name' => 'All types',
    'view' => 'all_types',
    'single' => true,
    'fields' => [
        [
            'key' => 'multi_file',
            'type' => 'multi_file',
        ],
    ],
];
