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
     * Returns the key for a child field.
     * 
     * @param  strin  $childKey
     * @return string
     */
    public function getChildKey(string $childKey): string
    {
        return sprintf(
            '%s[%s]',
            $this->getKey(),
            $childKey,
        );
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
        $values = $this->getValue();

        return array_map(function ($config) use ($values) {
            $originalKey = data_get($config, 'key');

            // The key of the field needs to be altered to a key that belongs
            // to its parent. This should be done to make it easier to retrieve
            // the values and to prevent interference with other fields.
            $config['key'] = $this->getChildKey($originalKey);

            return Factory::make($config)
                ->setValue(data_get($values, $originalKey));
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
            // Validation for keys of objects is done with keys that are dot
            // notated. "parent[child]" should be transformed to "parent.child"
            // in order for Laravel to be able to validate.
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
}
