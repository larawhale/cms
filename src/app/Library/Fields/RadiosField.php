<?php

namespace LaraWhale\Cms\Library\Fields;

class RadiosField extends MultiCheckableField
{
    /**
     * Returns the type of the input.
     *
     * @return string
     */
    public function getInputType(): string
    {
        return 'radio';
    }
}
