<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Fields;

use PHPUnit\Framework\TestCase;
use LaraWhale\Cms\Library\Fields\BasicField;
use LaraWhale\Cms\Library\Fields\Contracts\BasicFieldInterface;

class BasicFieldTest extends TestCase
{
    /**
     * The BasicField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\Contracts\BasicFieldInterface
     */
    private BasicField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new BasicField('test_key', 'test_type', 'test_value');
    }

    /** @test */
    public function get_key(): void
    {
        $this->assertEquals('test_key', $this->field->getKey());
    }

    /** @test */
    public function get_type(): void
    {
        $this->assertEquals('test_type', $this->field->getType());
    }

    /** @test */
    public function get_value(): void
    {
        $this->assertEquals('test_value', $this->field->getValue());
    }

    /** @test */
    public function set_value(): void
    {
        $this->field->setValue('value_test');

        $this->assertEquals('value_test', $this->field->getValue());
    }
}
