<?php

namespace LaraWhale\Cms\Tests\Unit\Library\Fields\Concerns;

use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\Concerns\HasList;

class HasListClass
{
    use HasList;

    /**
     * The list property.
     * 
     * @var array
     */
    public array $list;

    /**
     * The HasListClass constructor.
     * 
     * @param  array  $list
     */
    public function __construct(array $list = [])
    {
        $this->list = $list;
    }

    /**
     * A mock for the `config` method.
     * 
     * @return array
     */
    public function config(): array
    {
        return $this->list;
    }
}

class HasListTest extends TestCase
{

    /** @test */
    public function get_list(): void
    {
        $field = new HasListClass(['item 1', 'item 2', 'item 3']);

        $this->assertSame(
            ['item 1', 'item 2', 'item 3'],
            $field->getList(),
        );
    }

    /** @test */
    public function get_list_default(): void
    {
        $field = new HasListClass;

        $this->assertSame(
            [],
            $field->getList(),
        );
    }
}
