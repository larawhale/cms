<?php

namespace LaraWhale\Cms\Library\Fields;

use Collective\Html\FormFacade;
use LaraWhale\Cms\Library\Fields\Concerns\HasList;

class SelectField extends InputField
{
    use HasList;

    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return FormFacade::select(
            $this->getKey(),
            $this->getList(),
            $this->getInputValue(),
            $this->getInputAttributes(),
        )->toHtml();
    }
}
