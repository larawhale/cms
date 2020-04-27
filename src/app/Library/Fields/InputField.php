<?php

namespace LaraWhale\Cms\Library\Fields;

use Collective\Html\FormFacade;

class InputField extends AbstractField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return FormFacade::input(
            $this->getType(),
            $this->getKey(),
            $this->getInputValue(),
            [
                'class' => $this->getInputClass(),
                'id' => $this->getKey(),
            ],
        )->toHtml();
    }

    /**
     * Returns the css class for the rendered input.
     *
     * @return string
     */
    public function getInputClass(): string
    {
        $classes = ['form-control'];

        if (request()->hasSession()
            && optional(request()->session()->get('errors'))->has($this->getKey())
        ) {
            $classes[] = 'is-invalid';
        }

        return implode(' ', $classes);
    }
}
