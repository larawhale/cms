<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Entries\Entry;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Library\Fields\EntrySelectField;
use LaraWhale\Cms\Tests\Support\Models\CustomEntryModel;
use LaraWhale\Cms\Exceptions\ClassNotEntryModelException;

class EntrySelectFieldTest extends TestCase
{
    /**
     * The EntrySelectField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\EntrySelectField
     */
    private EntrySelectField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new EntrySelectField('test_key', 'entry_select', [
            'query_constraint' => function ($query) {
                $query->limit(15);
            },
            'list_item_label_key' => 'test_key',
            'entry_type' => 'test_entry',
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        EntryModel::factory()
            ->count(3)
            ->withFields()
            ->create(['type' => 'test_entry']);

        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }

    /** @test */
    public function get_entry_type(): void
    {
        $this->assertSame(
            'test_entry',
            $this->field->getEntryType(),
        );
    }

    /** @test */
    public function get_entry_type_default(): void
    {
        $field = new EntrySelectField('test_key', 'entry_select');

        $this->assertNull($field->getEntryType());
    }

    /** @test */
    public function get_list(): void
    {
        $list = EntryModel::factory()
            ->count(3)
            ->withFields()
            ->create(['type' => 'test_entry'])
            ->mapWithKeys(function ($entry) {
                $fieldModel = $entry->fields()
                    ->where('key', 'test_key')
                    ->first();

                return [$entry->id => $fieldModel->value];
            })
            ->all();

        $this->assertSame(
            $list,
            $this->field->getList(),
        );
    }

    /** @test */
    public function get_model_class(): void
    {
        $field = new EntrySelectField('test_key', 'entry_select', [
            'model_class' => CustomEntryModel::class,
        ]);

        $this->assertSame(
            CustomEntryModel::class,
            $field->getModelClass(),
        );
    }

    /** @test */
    public function get_model_class_default(): void
    {
        $this->assertSame(
            EntryModel::class,
            $this->field->getModelClass(),
        );
    }

    /** @test */
    public function get_model_class_throws_class_not_entry_model_exception(): void
    {
        $field = new EntrySelectField('test_key', 'entry_select', [
            'model_class' => static::class,
        ]);

        try {
            $field->getModelClass();
        } catch (ClassNotEntryModelException $e) {
            $this->assertEquals(static::class, $e->getClass());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function get_model_list_query(): void
    {
        $this->assertMatchesSnapshot(
            $this->field->getModelListQuery()->toSql(),
        );
    }

    /** @test */
    public function get_value(): void
    {
        $entryModel = EntryModel::factory()
            ->withFields()
            ->create(['type' => 'test_entry']);

        $fieldModel = $entryModel->fields()
            ->first();

        $fieldModel->update(['value' => $entryModel->id]);

        $field = new EntrySelectField(
            'test_key',
            'entry_select',
            ['entry_type' => 'test_entry'],
            $fieldModel,
        );

        $entry = $field->getValue();

        $this->assertInstanceOf(Entry::class, $entry);

        $this->assertEquals(
            $entryModel->id,
            $entry->getEntryModel()->id,
        );
    }
}
