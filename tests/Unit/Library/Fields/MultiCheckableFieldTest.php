<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\MultiCheckableField;

class MultiCheckableFieldTest extends TestCase
{
    /**
     * The MultiCheckableField instance used for testing.
     * 
     * @var \LaraWhale\Cms\Library\Fields\MultiCheckableField
     */
    private MultiCheckableField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new MultiCheckableField('test_key', 'multi_checkable');
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }
}
