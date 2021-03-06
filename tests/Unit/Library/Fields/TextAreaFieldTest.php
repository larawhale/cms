<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\TextAreaField;

class TextAreaFieldTest extends TestCase
{
    /**
     * The TextAreaField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\TextAreaField
     */
    private TextAreaField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new TextAreaField('test_key', 'textarea');
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }
}
