<?php

namespace Tests\Unit\Library\Fields;

use LaraWhale\Cms\Models\User;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Library\Fields\ModelSelectField;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;

class ModelSelectFieldTest extends TestCase
{
    /**
     * The ModelSelectField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\ModelSelectField
     */
    private ModelSelectField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new ModelSelectField('test_key', 'model_select', [
            'query_constraint' => function ($query) {
                $query->limit(15);
            },
            'list_item_label_key' => 'name',
            'model_class' => User::class,
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        User::factory()->count(3)->create([
            'name' => 'test_name',
        ]);

        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }

    /** @test */
    public function get_list(): void
    {
        $list = User::factory()->count(3)
            ->create()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->name];
            })
            ->all();

        $this->assertSame(
            $list,
            $this->field->getList(),
        );
    }

    /** @test */
    public function get_list_item_label_key(): void
    {
        $this->assertSame(
            'name',
            $this->field->getListItemLabelKey(),
        );
    }

    /** @test */
    public function get_list_item_label_key_default(): void
    {
        $field = new ModelSelectField('test_key', 'model_select');

        $this->assertSame(
            'id',
            $field->getListItemLabelKey(),
        );
    }

    /** @test */
    public function get_model_class(): void
    {
        $this->assertSame(
            User::class,
            $this->field->getModelClass(),
        );
    }

    /** @test */
    public function get_model_class_throws_required_config_exception(): void
    {
        $field = new ModelSelectField('test_key', 'model_select');

        try {
            $field->getModelClass();
        } catch (RequiredConfigKeyNotFoundException $e) {
            $this->assertEquals('model_class', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }

    /** @test */
    public function get_model_list(): void
    {
        $list = User::factory()->count(3)->create()->fresh();

        $this->assertEquals(
            $list,
            $this->field->getModelList(),
        );
    }

    /** @test */
    public function get_model_list_query(): void
    {
        $this->assertMatchesSnapshot(
            $this->field->getModelListQuery()->toSql(),
        );
    }

    /** @test */
    public function get_query_constraint(): void
    {
        $constraint = function ($query) {
            $query->limit(15);
        };

        $field = new ModelSelectField('test_key', 'model_select', [
            'model_class' => User::class,
            'query_constraint' => $constraint,
        ]);

        $this->assertSame(
            $constraint,
            $field->getQueryConstraint(),
        );
    }

    /** @test */
    public function get_value(): void
    {
        $user = User::factory()->create()->fresh();

        $fieldModel = new FieldModel([
            'value' => $user->id,
        ]);

        $field = new ModelSelectField(
            'test_key',
            'model_select',
            ['model_class' => User::class],
            $fieldModel,
        );

        $this->assertEquals(
            $user,
            $field->getValue(),
        );
    }

    /** @test */
    public function get_value_default(): void
    {
        $this->assertNull($this->field->getValue());
    }
}
