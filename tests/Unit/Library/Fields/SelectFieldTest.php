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

    /** @test */
    public function get_list(): void
    {
        $this->assertSame(
            ['item 1', 'item 2', 'item 3'],
            $this->field->getList(),
        );
    }

    /** @test */
    public function get_list_default(): void
    {
        // Create a field instance without a config that contains a `list` key.
        $field = new SelectField('test_key', 'select');

        $this->assertSame(
            [],
            $field->getList(),
        );
    }
}
