<?php

namespace LaraWhale\Cms\Library\Fields;

use Collective\Html\FormFacade;

class CheckableField extends InputField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.checkable', [
            'label' => $this->getLabel(),
            'name' => $this->getKey(),
            'options' => $this->getInputAttributes(),
            'type' => $this->getType(),
            'value' => $this->getInputValue(),
        ])->render();
    }

    /**
     * Returns the css class for the rendered input.
     *
     * @return string
     */
    public function getInputClass(): array
    {
        $classes = parent::getInputClass();

        $classes[] = 'custom-control-input';

        return array_unique($classes);
    }
}
