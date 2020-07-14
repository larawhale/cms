<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\CheckboxesField;

class CheckboxesFieldTest extends TestCase
{
    /**
     * The CheckboxesField instance used for testing.
     * 
     * @var \LaraWhale\Cms\Library\Fields\CheckboxesField
     */
    private CheckboxesField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new CheckboxesField('test_key', 'checkboxes', [
            'list' => ['item 1', 'item 2', 'item 3']
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }
}
