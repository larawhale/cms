<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\Factory;
use LaraWhale\Cms\Library\Fields\DefaultField;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;

class TestField extends DefaultField
{
    //
}

class FactoryTest extends TestCase
{
    /** @test */
    public function make(): void
    {
        Factory::$fields = [
            'test' => TestField::class,
        ];

        $field = Factory::make(['type' => 'test']);

        $this->assertInstanceOf(TestField::class, $field);
    }

    /** @test */
    public function make_default(): void
    {
        $field = Factory::make(['type' => 'default']);

        $this->assertInstanceOf(DefaultField::class, $field);
    }

    /** @test */
    public function make_default_unknown(): void
    {
        $field = Factory::make(['type' => 'test']);

        $this->assertInstanceOf(DefaultField::class, $field);
    }

    /** @test */
    public function get_type(): void
    {
        $type = Factory::getType(['type' => 'test']);

        $this->assertEquals('test', $type);
    }

    /** @test */
    public function get_type_throws_required_config_exception(): void
    {
        try {
            Factory::getType([]);
        } catch (RequiredConfigKeyNotFoundException $e) {
            $this->assertEquals('type', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }
}
