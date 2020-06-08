<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\MultiSelectField;

class MultiSelectFieldTest extends TestCase
{
    /**
     * The MultiSelectField instance used for testing.
     * 
     * @var \LaraWhale\Cms\Library\Fields\MultiSelectField
     */
    private MultiSelectField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new MultiSelectField('test_key', 'multi_select', [
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
