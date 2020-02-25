<?php

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Fields\DefaultField;
use LaraWhale\Cms\Exceptions\RequriedConfigKeyNotFoundException;

class DefaultFieldTest extends TestCase
{
    /**
     * A field config.
     */
    private array $config = [
        'key' => 'test_key',
        'type' => 'test_type',
        'rules' => 'test_rules',
        'label' => 'test_label',
    ];

    /** @test */
    public function key(): void
    {
        $field = new DefaultField($this->config);

        $this->assertEquals($this->config['key'], $field->key());
    }

    /** @test */
    public function key_throws_required_config_exception(): void
    {
        $field = new DefaultField([]);

        try {
            $field->key();
        } catch (RequriedConfigKeyNotFoundException $e) {
            $this->assertEquals('key', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function type(): void
    {
        $field = new DefaultField($this->config);

        $this->assertEquals($this->config['type'], $field->type());
    }

    /** @test */
    public function type_throws_required_config_exception(): void
    {
        $field = new DefaultField([]);

        try {
            $field->type();
        } catch (RequriedConfigKeyNotFoundException $e) {
            $this->assertEquals('type', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function rules(): void
    {
        $field = new DefaultField($this->config);

        $this->assertEquals($this->config['rules'], $field->rules());
    }

    /** @test */
    public function label(): void
    {
        $field = new DefaultField($this->config);

        $this->assertEquals($this->config['label'], $field->label());
    }

    /** @test */
    public function label_uses_key(): void
    {
        $field = new DefaultField(['key' => $this->config['key']]);

        $this->assertEquals($this->config['key'], $field->label());
    }

    /** @test */
    public function label_throws_required_config_exception(): void
    {
        $field = new DefaultField([]);

        try {
            $field->label();
        } catch (RequriedConfigKeyNotFoundException $e) {
            $this->assertEquals('key', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function render_input(): void
    {
        $field = new DefaultField($this->config);

        $this->assertMatchesHtmlSnapshot($field->renderInput());
    }

    /** @test */
    public function render_form_group(): void
    {
        $field = new DefaultField($this->config);

        $this->assertMatchesHtmlSnapshot($field->renderFormGroup());
    }

    /** @test */
    public function save_create(): void
    {
        $entryModel = factory(EntryModel::class)->create();

        $field = new DefaultField($this->config);

        $field->save($entryModel, 'test_value');

        $this->assertDatabaseHas('fields', [
            'entry_id' => $entryModel->id,
            'key' => $field->key(),
            'value' => 'test_value',
        ]);
    }

    /** @test */
    public function save_update(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['key'],
            'value' => 'old_value',
        ]);

        $field = new DefaultField($this->config);

        $field->save($fieldModel->entry, 'new_value');

        $this->assertDatabaseHas('fields', [
            'id' => $fieldModel->id,
            'entry_id' => $fieldModel->entry->id,
            'key' => $field->key(),
            'value' => 'new_value',
        ]);
    }
}
