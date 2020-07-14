<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\RadiosField;

class RadiosFieldTest extends TestCase
{
    /**
     * The RadiosField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\RadiosField
     */
    private RadiosField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new RadiosField('test_key', 'radios', [
            'list' => ['item 1', 'item 2', 'item 3']
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }
}
