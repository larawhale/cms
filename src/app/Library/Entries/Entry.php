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

    // TODO: Add to interface
    /**
     * This is just semi pseudo code, this does not work.
     * 
     * Will be called like Entry::save(new EntryModel, $request->validated())
     */
    public static function save(EntryModel $entryModel, array $data): EntryModel
    {
        $entryModel->fill($data)->save();

        return $entryModel;

        $entry = $entryModel->toEntryClass(); // Factory::make($entryModel->type);

        $fieldValues = data_get($data, 'fields', []);

        foreach ($entry->fields as $field) {
            if (! array_key_exists($field->key(), $fieldValues)) {
                continue;
            }

            $field->save($entryModel, $fieldValue);
        }
    }
}
