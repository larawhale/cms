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
     * Returns a representation of how the value should be stored in the
     * database.
     *
     * @param  mixed  $value
     * @return string
     */
    public function getDatabaseValue($value): string
    {
        return $this->traitGetDatabaseValue(array_map(
            fn ($v) => $this->getDatabaseValueChildren($v),
            $value,
        ));
    }

    /**
     * Returns the fields as field instances.
     *
     * @param  bool  $withParentKey
     * @param  mixed  $value
     * @return array
     */
    public function getFieldInstances(bool $withParentKey = true, $value = null): array
    {
        return array_map(function ($v) use ($withParentKey) {
            return parent::getFieldInstances($withParentKey, $v);
        }, $this->getValue());
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
