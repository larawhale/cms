<?php

namespace LaraWhale\Cms\Database\Factories;

use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Database\Factories\FieldFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use LaraWhale\Cms\Library\Entries\Factory as EntryFactoryClass;

class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $entryConfig = Arr::random(EntryFactoryClass::$entries);

        $field = Arr::random($entryConfig['fields']);

        return [
            'entry_id' => function () use ($entryConfig) {
                return Entry::factory()->create([
                    'type' => $entryConfig['type'],
                ])->id;
            },
            'key' => $field['key'],
            'type' => $field['type'],
            'value' => $field['key'] . '_value',
        ];
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory(): Factory
    {
        return FieldFactory::new();
    }
}
