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
            $this->getInputAttributes(),
        )->toHtml();
    }

    /**
     * Returns the attributes for the rendered input.
     *
     * @return array
     */
    public function getInputAttributes(): array
    {
        $configured = $this->config('input_attributes', []);

        // Alter class directly instead of merging because `getInputClass`
        // retrieves the configured class and appends to it. Altering directly
        // will prevent is to be overwritten during merge.
        $configured['class'] = $this->getInputClass();

        $default = [
            'id' => $this->getInputId(),
        ];

        return array_merge($default, $configured);
    }

    /**
     * Returns the css class for the rendered input.
     *
     * @return array
     */
    public function getInputClass(): array
    {
        $classes = $this->config('input_attributes.class', []);

        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }

        $classes[] = 'form-control';

        if ($this->inputIsInvalid()) {
            $classes[] = 'is-invalid';
        }

        return array_unique($classes);
    }

    /**
     * Returns the css id for the rendered input.
     *
     * @return string
     */
    public function getInputId(): string
    {
        return $this->config('input_attributes.id', fn() => $this->getKey());
    }

    /**
     * Returns whether the input has been submitted in a request with an
     * invalid value.
     *
     * @return bool
     */
    public function inputIsInvalid(): bool
    {
        return request()->hasSession()
            && optional(request()->session()->get('errors'))
                ->has($this->getKey());
    }
}
