<?php

use Orchestra\Testbench\TestCase;
use LaraWhale\Cms\Library\Fields\DefaultField;

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

        try {
            $field->key();
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            $this->assertEquals('key', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }
}
