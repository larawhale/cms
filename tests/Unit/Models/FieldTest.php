<?php

namespace LaraWhale\Cms\Tests\Unit\Models;

use LaraWhale\Cms\Models\Field;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface;

class FieldTest extends TestCase
{
    /** @test */
    public function to_field_class(): void
    {
        $field = new Field([
            'key' => 'test_field',
            'type' => 'test_field',
        ]);

        $this->assertInstanceOf(
            AbstractFieldInterface::class,
            $field->toFieldClass(),
        );
    }
}
