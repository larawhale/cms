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
            'height' => $this->getPreviewHeight(),
            'width' => $this->getPreviewWidth(),
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

    /**
     * Returns the height in which the image should be previewed.
     * 
     * @return string|int
     */
    public function getPreviewHeight()
    {
        return $this->config(
            'preview_height',
            config('cms.fields.image_field.default_preview_height', '100px'),
        );
    }

    /**
     * Returns the width in which the image should be previewed.
     * 
     * @return string|int
     */
    public function getPreviewWidth()
    {
        return $this->config(
            'preview_width',
            config('cms.fields.image_field.default_preview_width', '100px'),
        );
    }
}
