<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Tests\Support\Fields\TestField;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;
use LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface;

class AbstractFieldTest extends TestCase
{
    /**
     * The AbstractFieldInterface instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface
     */
    private AbstractFieldInterface $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new TestField(
            'test_key',
            'test_type',
            [
                'rules' => ['required'],
                'label' => 'Test label',
            ],
        );
    }

    /** @test */
    public function get_database_value(): void
    {
        $this->assertSame(
            '123',
            $this->field->getDatabaseValue(123),
        );
    }

    /** @test */
    public function get_input_value(): void
    {
        $this->assertSame(
            // The input value should by default be the same as the value.
            $this->field->getValue(),
            $this->field->getInputValue(),
        );
    }

    /** @test */
    public function get_rules(): void
    {
        $this->assertSame(
            ['required'],
            $this->field->getRules(),
        );
    }

    /** @test */
    public function get_rules_default(): void
    {
        $field = new TestField(
            'test_key',
            'test_type',
            // Do not add a config with a `rules` key so we can test the
            // default value.
        );

        $this->assertSame(
            [],
            $field->getRules(),
        );
    }

    /** @test */
    public function get_rules_with_key(): void
    {
        $this->assertSame(
            ['test_key' => ['required']],
            $this->field->getRulesWithKey(),
        );
    }

    /** @test */
    public function get_label(): void
    {
        $this->assertSame(
            'Test label',
            $this->field->getLabel(),
        );
    }

    /** @test */
    public function get_label_default(): void
    {
        $field = new TestField(
            'test_key',
            'test_type',
            // Do not add a config with a `label` key so we can test the
            // default value.
        );

        $this->assertSame(
            // The default value of `getLabel` should be the `key` of the
            // field.
            'test_key',
            $field->getLabel(),
        );
    }

    /** @test */
    public function set_field_model(): void
    {
        $fieldModel = new FieldModel([
            'value' => 'field_model_value',
        ]);

        $this->field->setFieldModel($fieldModel);

        $this->assertSame(
            $fieldModel,
            $this->field->getFieldModel(),
        );

        // The value of the field model should be set to the value of the
        // field.
        $this->assertSame(
            $fieldModel->value,
            $this->field->getValue(),
        );
    }

    /** @test */
    public function set_field_model_null(): void
    {
        $this->field->setFieldModel(null);

        $this->assertSame(
            null,
            $this->field->getFieldModel(),
        );

        // The field model is `null`, thus the value should be `null`.
        $this->assertSame(
            null,
            $this->field->getValue(),
        );
    }

    /** @test */
    public function render_form_group(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderFormGroup());
    }

    /** @test */
    public function save_create(): void
    {
        $entryModel = factory(EntryModel::class)->create();

        $this->field->save($entryModel, 'test_value');

        $this->assertDatabaseHas('fields', [
            'entry_id' => $entryModel->id,
            'key' => $this->field->getKey(),
            'type' => $this->field->getType(),
            'value' => 'test_value',
        ]);
    }

    /** @test */
    public function save_update(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->field->getKey(),
            'type' => $this->field->getType(),
            'value' => 'old_value',
        ]);

        $this->field->save($fieldModel->entry, 'new_value');

        $this->assertDatabaseHas('fields', [
            'id' => $fieldModel->id,
            'entry_id' => $fieldModel->entry->id,
            'key' => $this->field->getKey(),
            'type' => $this->field->getType(),
            'value' => 'new_value',
        ]);
    }
}
