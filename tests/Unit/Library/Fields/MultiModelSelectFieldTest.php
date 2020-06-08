<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\MultiModelSelectField;

class MultiModelSelectFieldTest extends TestCase
{
    /**
     * The MultiModelSelectField instance used for testing.
     * 
     * @var \LaraWhale\Cms\Library\Fields\MultiModelSelectField
     */
    private MultiModelSelectField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new MultiModelSelectField('test_key', 'select', [
            'list_item_label_key' => 'name',
            'model_class' => User::class,
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        factory(User::class, 3)->create([
            'name' => 'test_name',
        ]);

        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }
}
