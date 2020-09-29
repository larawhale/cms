<?php

namespace LaraWhale\Cms\Database\Factories;

use Illuminate\Support\Arr;
use LaraWhale\Cms\Models\Entry;
use LaraWhale\Cms\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;
use LaraWhale\Cms\Library\Entries\Factory as EntryFactoryClass;

class EntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => Arr::random(array_keys(EntryFactoryClass::$entries)),
        ];
    }

    /**
     * Create fields for the entry.
     * 
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withFields(): Factory
    {
        return $this->afterCreating(function (Entry $entry) {
            $fields = $entry->toEntryClass()->getFields();

            foreach ($fields as $field) {
                Field::factory()->create([
                    'entry_id' => $entry->id,
                    'key' => $field->getKey(),
                    'value' => $field->getKey() . '_value',
                ]);
            }
        });
    }
}
