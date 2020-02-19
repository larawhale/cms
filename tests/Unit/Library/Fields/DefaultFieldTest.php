<?php

use Orchestra\Testbench\TestCase;
use LaraWhale\Cms\Library\Fields\DefaultField;
use LaraWhale\Cms\Exceptions\RequriedFieldConfigKeyNotFoundException;

class DefaultFieldTest extends TestCase
{
    /**
     * A field config.
     */
    private array $config = [
        'key' => 'test_key',
        'type' => 'test_type',
        'rules' => 'test_rules',
    ];

    /** @test */
    public function config(): void
    {
        $field = new DefaultField($this->config);

        $this->assertEquals($this->config, $field->config());
    }

    /** @test */
    public function config_with_key(): void
    {
        $field = new DefaultField($this->config);

        $this->assertEquals($this->config['key'], $field->config('key'));
    }

    /** @test */
    public function config_with_key_and_default(): void
    {
        $field = new DefaultField([]);

        $this->assertEquals('default', $field->config('key', 'default'));
    }

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

        $this->expectException(RequriedFieldConfigKeyNotFoundException::class);

        $field->key();
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

        $this->expectException(RequriedFieldConfigKeyNotFoundException::class);

        $field->type();
    }

    /** @test */
    public function rules(): void
    {
        $field = new DefaultField($this->config);

        $this->assertEquals($this->config['rules'], $field->rules());
    }
}
