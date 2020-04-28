<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Fields;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\Factory;
use LaraWhale\Cms\Library\Fields\InputField;
use LaraWhale\Cms\Tests\Support\Fields\TestField;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;


class FactoryTest extends TestCase
{
    /** @test */
    public function make(): void
    {
        Factory::$fields = [
            'test' => TestField::class,
        ];

        $field = Factory::make([
            'key' => 'test_key',
            'type' => 'test',
        ]);

        $this->assertInstanceOf(TestField::class, $field);
    }

    /** @test */
    public function make_default(): void
    {
        $field = Factory::make([
            'key' => 'test_key',
            'type' => 'default',
        ]);

        $this->assertInstanceOf(InputField::class, $field);
    }

    /** @test */
    public function make_default_unknown(): void
    {
        $field = Factory::make([
            'key' => 'test_key',
            'type' => 'test',
        ]);

        $this->assertInstanceOf(InputField::class, $field);
    }

    /** @test */
    public function get_from_config(): void
    {
        $key = Factory::getFromConfig('key', [
            'key' => 'test_key',
            'type' => 'test_type',
        ]);

        $this->assertEquals('test_key', $key);
    }

    /** @test */
    public function get_from_config_throws_required_config_exception(): void
    {
        try {
            Factory::getFromConfig('key', []);
        } catch (RequiredConfigKeyNotFoundException $e) {
            $this->assertEquals('key', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }
}
