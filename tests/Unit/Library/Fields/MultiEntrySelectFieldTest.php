<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Library\Fields\MultiEntrySelectField;

class MultiEntrySelectFieldTest extends TestCase
{
    /**
     * The MultiEntrySelectField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\MultiEntrySelectField
     */
    private MultiEntrySelectField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new MultiEntrySelectField('test_key', 'select', [
            'list_item_label_key' => 'test_key',
            'entry_type' => 'test_entry',
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        factory(EntryModel::class, 3)
            ->state('with_fields')
            ->create(['type' => 'test_entry']);

        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }
}
