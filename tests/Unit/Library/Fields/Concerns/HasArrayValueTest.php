<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Fields\Concerns;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\Concerns\HasArrayValue;

class HasArrayValueClass
{
    use HasArrayValue;

    /**
     * The value property.
     * 
     * @var array|string|null
     */
    public $value;

    /**
     * The HasArrayValueClass constructor.
     * 
     * @param  array|string|null  $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }
}

class HasArrayValueTest extends TestCase
{
    /** @test */
    public function get_value_null(): void
    {
        $class = new HasArrayValueClass;

        $this->assertSame(
            [],
            $class->getValue(),
        );
    }

    /** @test */
    public function get_value_string(): void
    {
        $class = new HasArrayValueClass('{"key": "value"}');

        $this->assertSame(
            ['key' => 'value'],
            $class->getValue(),
        );
    }

    /** @test */
    public function get_value_array(): void
    {
        $class = new HasArrayValueClass(['key' => 'value']);

        $this->assertSame(
            ['key' => 'value'],
            $class->getValue(),
        );
    }

    /** @test */
    public function get_database_value_null(): void
    {
        $class = new HasArrayValueClass;

        $this->assertSame(
            '',
            $class->getDatabaseValue(null),
        );
    }

    /** @test */
    public function get_database_value_string(): void
    {
        $class = new HasArrayValueClass;

        $this->assertSame(
            '{"key": "value"}',
            $class->getDatabaseValue('{"key": "value"}'),
        );
    }

    /** @test */
    public function get_database_value_array(): void
    {
        $class = new HasArrayValueClass;

        $this->assertSame(
            '{"key":"value"}',
            $class->getDatabaseValue(['key' => 'value']),
        );
    }
    /** @test */
    public function get_input_value_null(): void
    {
        $class = new HasArrayValueClass;

        $this->assertSame(
            [],
            $class->getInputValue(),
        );
    }

    /** @test */
    public function get_input_value_string(): void
    {
        $class = new HasArrayValueClass('{"key": "value"}');

        $this->assertSame(
            ['key' => 'value'],
            $class->getInputValue(),
        );
    }

    /** @test */
    public function get_input_value_array(): void
    {
        $class = new HasArrayValueClass(['key' => 'value']);

        $this->assertSame(
            ['key' => 'value'],
            $class->getInputValue(),
        );
    }
}
