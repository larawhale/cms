<?php

namespace LaraWhale\Cms\Library\Fields;

use LaraWhale\Cms\Library\Fields\Concerns\HasArrayValue;

class MultiSelectField extends SelectField
{
    use HasArrayValue;

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
