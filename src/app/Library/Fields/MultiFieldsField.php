<?php

namespace LaraWhale\Cms\Library\Fields;

class MultiFieldsField extends FieldsField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.multi-fields', [
            'name' => $this->getKey(),
            'fields' => $this->getFieldInstances(),
            'value' => $this->getInputValue(),
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
            '%s[0][%s]',
            $this->getKey(),
            $childKey,
        );
    }

    /**
     * Returns the configured rules of the field with the key of the field.
     *
     * @return array
     */
    public function getRulesWithKey(): array
    {
        return collect(parent::getRulesWithKey())
            ->mapWithKeys(function ($rules, $key) {
                $newKey = preg_replace('/\.\d\./', '.*.', $key);

                return [$newKey => $rules];
            })
            ->all();
    }
}
