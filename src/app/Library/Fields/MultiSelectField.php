<?php

namespace LaraWhale\Cms\Library\Fields;

class MultiSelectField extends SelectField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.multi-select', [
            'name' => $this->getKey(),
            'list' => $this->getList(),
            'value' => $this->getInputValue(),
            'attributes' => $this->getInputAttributes(),
        ])->render();
    }
}
