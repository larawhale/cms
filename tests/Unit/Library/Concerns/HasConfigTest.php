<?php

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Concerns\HasConfig;
use LaraWhale\Cms\Exceptions\RequriedConfigKeyNotFoundException;


class HasConfigClass
{
    use HasConfig;

    /**
     * The HasConfigClass constructor.
     * 
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}

class HasConfigTest extends TestCase
{
    /**
     * The config of the class.
     * 
     * @var array
     */
    private array $config = [
        'key' => 'value',
    ];

    /** @test */
    public function config(): void
    {
        $class = new HasConfigClass($this->config);

        $this->assertEquals($this->config, $class->config());
    }

    /** @test */
    public function config_with_key(): void
    {
        $class = new HasConfigClass($this->config);

        $this->assertEquals($this->config['key'], $class->config('key'));
    }

    /** @test */
    public function config_with_key_and_default(): void
    {
        $class = new HasConfigClass([]);

        $this->assertEquals('default', $class->config('key', 'default'));
    }

    /** @test */
    public function config_throws_required_config_exception(): void
    {
        $class = new HasConfigClass([]);

        try {
            $class->config('key', null, true);
        } catch (RequriedConfigKeyNotFoundException $e) {
            $this->assertEquals('key', $e->getKey());

            return;
        }

        $this->assertTrue(false, 'Exception was not thrown.');
    }
}
