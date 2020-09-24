<?php

namespace LaraWhale\Cms\Tests\Unit\Library;

use LaraWhale\Cms\Tests\TestCase;

class HelpersTest extends TestCase
{
    /** @test */
    public function array_filter_recursive(): void
    {
        $this->assertSame(
            [
                'not_null' => 'not_null',
                'not_null_array' => [
                    'not_null_array' => [
                        'not_null' => 'not_null',
                    ],
                ],
            ],
            array_filter_recursive([
                'null' => null,
                'not_null' => 'not_null',
                'null_array' => [
                    'null' => null,
                    'null_array' => [
                        'null' => null,
                    ],
                ],
                'not_null_array' => [
                    'null' => null,
                    'not_null_array' => [
                        'null' => null,
                        'not_null' => 'not_null',
                    ],
                ],
            ]),
        );
    }
}
