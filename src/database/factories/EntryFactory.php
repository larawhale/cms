<?php

use Faker\Generator;
use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Library\Entries\Factory;

$factory->define(Entry::class, function (Generator $faker) {
    return [
        'type' => Arr::random(array_keys(Factory::$entries)),
    ];
});

$factory->afterCreatingState(
    Entry::class,
    'with_fields',
    function (Entry $entry) {
        $fields = $entry->toEntryClass()->getFields();

        foreach ($fields as $field) {
            factory(Field::class)->create([
                'entry_id' => $entry->id,
                'key' => $field->getKey(),
                'value' => $field->getKey() . '_value',
            ]);
        }
    },
);
