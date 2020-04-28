<?php

namespace LaraWhale\Cms\Library\Fields;

use Collective\Html\FormFacade;

class TextAreaField extends InputField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return FormFacade::textarea(
            $this->getKey(),
            $this->getInputValue(),
            [
                'class' => $this->getInputClass(),
                'id' => $this->getKey(),
            ],
        )->toHtml();
    }
}
