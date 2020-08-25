<?php

namespace Tests\Unit\Library\Fields;

use Mockery;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\MessageBag;
use LaraWhale\Cms\Library\Fields\InputField;
use LaraWhale\Cms\Library\Fields\FieldsField;

class FieldsFieldTest extends TestCase
{
    /**
     * The FieldsField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\FieldsField
     */
    private FieldsField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new FieldsField('test_key', 'fields', [
            'fields' => [
                [
                    'key' => 'test_key',
                    'type' => 'text',
                    'config' => ['rules' => 'required'],
                ],
            ],
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }

    /** @test */
    public function get_database_value(): void
    {
        $field = new FieldsField('test_key', 'fields', [
            'fields' => [
                [
                    'key' => 'test_key',
                    'type' => 'fields',
                    'config' => [
                        'fields' => [
                            [
                                'key' => 'test_key',
                                'type' => 'text',
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $this->assertSame(
            json_encode(['test_key' => json_encode(['test_key' => 'test_value'])]),
            $field->getDatabaseValue(['test_key' => ['test_key' => 'test_value']]),
        );
    }

    /** @test */
    public function get_fields(): void
    {
        $this->assertSame(
            [['key' => 'test_key', 'type' => 'text', 'config' => ['rules' => 'required']]],
            $this->field->getFields(),
        );
    }

    /** @test */
    public function get_field_instances(): void
    {
        $fieldInstances = $this->field->getFieldInstances();

        $this->assertCount(1, $fieldInstances);

        $actual = $fieldInstances[0];

        $this->assertInstanceOf(InputField::class, $actual);

        $this->assertSame('test_key[test_key]', $actual->getKey());

        $this->assertSame('text', $actual->getType());

        $this->assertSame('required', $actual->getRules());
    }

    /** @test */
    public function get_field_instances_without_parent_key(): void
    {
        $fieldInstances = $this->field->getFieldInstances(false);

        $actual = $fieldInstances[0];

        $this->assertSame('test_key', $actual->getKey());
    }

    /** @test */
    public function get_rules_with_key(): void
    {
        $this->assertSame(
            ['test_key.test_key' => 'required'],
            $this->field->getRulesWithKey(),
        );
    }
}
