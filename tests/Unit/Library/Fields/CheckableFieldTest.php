<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\CheckableField;

class CheckableFieldTest extends TestCase
{
    /**
     * The CheckableField instance used for testing.
     * 
     * @var \LaraWhale\Cms\Library\Fields\CheckableField
     */
    private CheckableField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new CheckableField([
            'key' => 'test_key',
            'type' => 'checkbox',
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }

    /** @test */
    public function get_input_class(): void
    {
        $this->assertStringContainsString(
            'custom-control-input',
            $this->field->getInputClass(),
        );
    }
}
