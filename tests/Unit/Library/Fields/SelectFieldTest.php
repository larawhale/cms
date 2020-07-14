<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\SelectField;

class SelectFieldTest extends TestCase
{
    /**
     * The SelectField instance used for testing.
     * 
     * @var \LaraWhale\Cms\Library\Fields\SelectField
     */
    private SelectField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new SelectField('test_key', 'select', [
            'list' => [
                'item 1',
                'item 2',
                'item 3',
            ],
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }
}
