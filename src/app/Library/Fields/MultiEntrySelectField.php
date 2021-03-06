<?php

namespace LaraWhale\Cms\Library\Fields;

use LaraWhale\Cms\Library\Fields\Concerns\HasArrayValue;

class MultiEntrySelectField extends EntrySelectField
{
    use HasArrayValue;

    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.multi-select', [
            'name' => $this->getKey(),
            'list' => $this->getList(),
            'value' => $this->getInputValue(),
            'attributes' => $this->getInputAttributes(),
        ])->render();
    }

    /**
     * Returns the css class for the rendered input.
     *
     * @return array
     */
    public function getInputClass(): array
    {
        $classes = parent::getInputClass();

        return array_filter(
            $classes,
            fn($c) => ! in_array($c, ['form-control', 'custom-select']),
        );
    }
}
