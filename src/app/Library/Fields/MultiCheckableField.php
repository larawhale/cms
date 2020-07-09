<?php

namespace LaraWhale\Cms\Library\Fields;

use Collective\Html\FormFacade;
use LaraWhale\Cms\Library\Fields\Concerns\HasList;

class MultiCheckableField extends CheckableField
{
    use HasList;

    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.checkables', [
            'list' => $this->getList(),
            'name' => $this->getKey(),
            'attributes' => $this->getInputAttributes(),
            'value' => $this->getInputValue(),
            'inline' => $this->getInline(),
            'type' => $this->getType() === 'checkboxes'
                ? 'checkbox'
                : 'radio',
        ])->render();
    }

    /**
     * Returns weither the checkables should be displayed inline or not.
     * 
     * @return bool
     */
    public function getInline(): bool
    {
        return $this->config('inline', true);
    }
}
