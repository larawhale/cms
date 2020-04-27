<?php

namespace LaraWhale\Cms\Tests\Support\Fields;

use LaraWhale\Cms\Library\Fields\AbstractField;

/**
 * A class that extends from the AbstractField and completes it with its
 * missing `renderInput` method. This class should only be used to test.
 */
class TestField extends AbstractField
{
    public function renderInput(): string
    {
        return 'rendered_input';
    }
}
