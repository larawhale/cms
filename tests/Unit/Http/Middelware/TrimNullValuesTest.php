<?php

namespace LaraWhale\Cms\Tests\Unit\Http\Middleware;

use Illuminate\Http\Request;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Http\Middleware\TrimNullValues;

class TrimNullValuesTest extends TestCase
{
    /** @test */
    public function trims_null_values(): void
    {
        $request = new Request([], [
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
        ]);

        (new TrimNullValues)->handle($request, function ($request) {
            $this->assertSame(
                [
                    'not_null' => 'not_null',
                    'not_null_array' => [
                        'not_null_array' => [
                            'not_null' => 'not_null',
                        ],
                    ],
                ],
                $request->request->all()
            );
        });
    }
}
