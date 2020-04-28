<?php

use Faker\Generator;
use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Library\Entries\Factory;

$factory->define(Field::class, function (Generator $faker) {
    $entryConfig = Arr::random(Factory::$entries);

    $field = Arr::random($entryConfig['fields']);

    return [
        'entry_id' => function () use ($entryConfig) {
            return factory(Entry::class)->create([
                'type' => $entryConfig['type'],
            ])->id;
        },
        'key' => $field['key'],
        'type' => $field['type'],
        'value' => $field['key'] . '_value',
    ];
});
