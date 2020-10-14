<?php

namespace LaraWhale\Cms\Library\Fields;

class MultiFileField extends FileField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.multi-file', [
            'name' => $this->getKey(),
            'attributes' => $this->getInputAttributes(),
            'value' => $this->getInputValue(),
        ])->render();
    }

    /**
     * Returns the css id for the rendered input.
     *
     * @return string
     */
    public function getInputId(): string
    {
        $id = parent::getInputId();

        return $id ? $id . '[]' : $id;
    }
}
