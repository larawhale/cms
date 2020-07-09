<?php

namespace LaraWhale\Cms\Library\Fields;

use Collective\Html\FormFacade;
use LaraWhale\Cms\Library\Fields\Concerns\HasList;
use LaraWhale\Cms\Library\Fields\Concerns\HasArrayValue;

class CheckboxesField extends CheckableField
{
    use HasArrayValue, HasList;

    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.checkboxes', [
            'list' => $this->getList(),
            'name' => $this->getKey(),
            'attributes' => $this->getInputAttributes(),
            'value' => $this->getInputValue(),
            'inline' => $this->getInline(),
        ])->render();
    }

    /**
     * Returns weither the checboxes should be displayed inline or not.
     * 
     * @return bool
     */
    public function getInline(): bool
    {
        return $this->config('inline', true);
    }
}
