<?php

namespace LaraWhale\Cms\Library\Fields;

use Illuminate\Support\Facades\Storage;

class ImageField extends FileField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.image', [
            'name' => $this->getKey(),
            'attributes' => $this->getInputAttributes(),
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

        $classes[] = 'custom-image-input';

        return array_unique($classes);
    }

    /**
     * Returns the value of the field in a form usable during the rendering of
     * the input.
     *
     * @return mixed
     */
    public function getInputValue()
    {
        return $this->value
            ? Storage::url($this->value)
            : $this->value;
    }
}
