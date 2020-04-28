<?php

namespace LaraWhale\Cms\Library\Fields;

use Collective\Html\FormFacade;

class SelectField extends InputField
{
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
            [
                'class' => $this->getInputClass(),
                'id' => $this->getKey(),
            ],
        )->toHtml();
    }

    /**
     * Returns the configured list used to display in the select.
     * 
     * @return array
     */
    public function getList(): array
    {
        return $this->config('list', []);
    }
}
