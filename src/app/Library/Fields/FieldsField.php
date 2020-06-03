<?php

namespace LaraWhale\Cms\Library\Fields;

use LaraWhale\Cms\Library\Fields\Factory;
use LaraWhale\Cms\Models\Entry as EntryModel;   
use LaraWhale\Cms\Library\Fields\Concerns\HasArrayValue;

class FieldsField extends InputField
{
    use HasArrayValue;

    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.fields', [
            'name' => $this->getKey(),
            'fields' => $this->getFieldInstances(),
        ])->render();
    }

    /**
     * Returns the fields that should be rendered.
     * 
     * @return array
     */
    public function getFields(): array
    {
        return $this->config('fields', []);
    }

    /**
     * Returns the fields as field instances.
     * 
     * @return array
     */
    public function getFieldInstances(): array
    {
        return array_map(function ($config) {
            // The key of the field needs to be altered to a key that belongs
            // to its parent. This should be done to make it easier to retrieve
            // the values and to prevent interference with other fields.
            $config['key'] = sprintf('%s[%s]',
                $this->getKey(),
                data_get($config, 'key'),
            );

            return Factory::make($config);
        }, $this->getFields());
    }

    /**
     * Returns the configured rules of the field with the key of the field.
     *
     * @return array
     */
    public function getRulesWithKey(): array
    {
        return collect($this->getFieldInstances())
            ->mapWithKeys(function ($field) {
                $explodedKey = str_replace(
                    ']',
                    '',
                    explode('[', $field->getKey()),
                );

                return [implode('.', $explodedKey) => $field->getRules()];
            })
            ->all();
    }

    /**
     * Saves the field to the database.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  mixed  $value
     * @return self
     */
    public function save(EntryModel $entryModel, $value): self
    {
        dd($value);
    }
}
