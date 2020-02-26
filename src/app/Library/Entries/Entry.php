<?php

namespace LaraWhale\Cms\Library\Entries;

use LaraWhale\Cms\Library\Fields\Factory;
use LaraWhale\Cms\Library\Concerns\HasConfig;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Library\Entries\Contracts\Entry as EntryInterface;

class Entry implements EntryInterface
{
    use HasConfig;

    /**
     * The Entry constructor.
     * 
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Returns the type of the entry.
     * 
     * @return string
     */
    public function type(): string
    {
        return $this->config('type', null, true);
    }

    /**
     * Returns the name of the entry.
     * 
     * @return string
     */
    public function name(): string
    {
        return $this->config('name', fn() => $this->type());
    }

    /**
     * Returns the fields of the entry.
     * 
     * @return array
     */
    public function fields(): array
    {
        return array_map(
            fn(array $config) => Factory::make($config),
            $this->config('fields', []),
        );
    }

    /**
     * Returns a rendered form.
     * 
     * @return string
     */
    public function renderForm(): string
    {
        return view('cms::entries.form', [
            'entry' => $this,
        ])->render();
    }

    /**
     * Saves an entry and its fields to the database.
     * 
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  array  $data
     * @return \LaraWhale\Cms\Models\Entry
     */
    public static function save(EntryModel $entryModel, array $data): EntryModel
    {
        $entryModel->fill($data)->save();

        $entry = $entryModel->toEntryClass();

        $fieldValues = data_get($data, 'fields', []);

        $fieldModels = collect();

        foreach ($entry->fields() as $field) {
            // Only save the value of the field when it is given in the field
            // values array.
            if (! array_key_exists($field->key(), $fieldValues)) {
                continue;
            }

            $fieldModels->push(
                $field->save($entryModel, $fieldValues[$field->key()]),
            );
        }

        // Remove the fields that are not in the entry configuration anymore.
        $entryModel->fields()
            ->whereNotIn(
                cms_table_name('fields') . '.id',
                $fieldModels->pluck('id'),
            )
            ->delete();

        return $entryModel;
    }
}
