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
}
