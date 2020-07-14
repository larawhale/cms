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
            'type' => $this->getInputType(),
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
