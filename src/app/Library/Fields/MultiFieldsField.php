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
        return view('cms::components.form.fields', [
            'name' => $this->getKey(),
            'fields' => $this->getFieldInstances(),
        ])->render();
    }
}
