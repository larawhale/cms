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
            'attributes' => $this->getInputAttributes(),
            'inline' => $this->getInline(),
            'list' => $this->getList(),
            'name' => $this->getKey(),
            'value' => $this->getInputValue(),
            'type' => $this->getInputType(,)
        ])->render();
    }

    /**
     * Returns the type of the input. This field uses this value instead of
     * the `type` to determine what kind of thing can be checked. This is
     * mainly because this field can be extended under a different name,
     * checkboxes for example.
     * 
     * @return string
     */
    public function getInputType(): string
    {
        return 'checkbox';
    }
}
