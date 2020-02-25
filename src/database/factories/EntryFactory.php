<?php

use Faker\Generator;
use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Library\Entries\Factory;

$factory->define(Entry::class, function (Generator $faker) {
    return [
        'type' => Arr::random(array_keys(Factory::$entries)),
    ];
});
