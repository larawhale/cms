<?php

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\MessageBag;
use LaraWhale\Cms\Models\Entry as EntryModel;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Fields\DefaultField;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;

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
        } catch (RequiredConfigKeyNotFoundException $e) {
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
        } catch (RequiredConfigKeyNotFoundException $e) {
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
        } catch (RequiredConfigKeyNotFoundException $e) {
            $this->assertEquals('key', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function set_field_model_sets_value(): void
    {
        $fieldModel = factory(FieldModel::class)->create();

        $field = new DefaultField($this->config);

        $field->setFieldModel($fieldModel);

        $this->assertEquals(
            $fieldModel->value,
            $field->value(),
        );
    }

    /** @test */
    public function set_field_model_sets_null(): void
    {
        $fieldModel = factory(FieldModel::class)->create();

        $field = new DefaultField($this->config);

        $field->setFieldModel(null);

        $this->assertEquals(
            null,
            $field->value(),
        );
    }

    /** @test */
    public function render_input(): void
    {
        $field = new DefaultField($this->config);

        $this->assertMatchesHtmlSnapshot($field->renderInput());
    }

    /** @test */
    public function input_class(): void
    {
        $field = new DefaultField($this->config);

        $session = Mockery::mock(Store::class)
            ->makePartial()
            ->shouldReceive('get')
            ->with('errors')
            ->andReturn(new MessageBag([
                $field->key() => 'Erroreeeee!!1!',
            ]));

        $request = Mockery::mock(Request::class)
            ->makePartial();

        $request->shouldReceive('hasSession')
            ->andReturn(true);

        $request->shouldReceive('session')
            ->andReturn($session->getMock());

        app()->instance('request', $request);

        $this->assertEquals(
            'form-control is-invalid',
            $field->inputClass(),
        );
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

        $fieldModel = $field->save($entryModel, 'test_value');

        $this->assertEquals(
            $fieldModel,
            $field->fieldModel(),
        );

        $this->assertDatabaseHas('fields', [
            'entry_id' => $entryModel->id,
            'key' => $field->key(),
            'type' => $field->type(),
            'value' => 'test_value',
        ]);
    }

    /** @test */
    public function save_update(): void
    {
        $fieldModel = factory(FieldModel::class)->create([
            'key' => $this->config['key'],
            'type' => $this->config['type'],
            'value' => 'old_value',
        ]);

        $field = new DefaultField($this->config);

        $field->save($fieldModel->entry, 'new_value');

        $this->assertDatabaseHas('fields', [
            'id' => $fieldModel->id,
            'entry_id' => $fieldModel->entry->id,
            'key' => $field->key(),
            'type' => $field->type(),
            'value' => 'new_value',
        ]);
    }

    /** @test */
    public function database_value(): void
    {
        $field = new DefaultField($this->config);

        $this->assertSame(
            '123',
            $field->databaseValue(123),
        );
    }
}
