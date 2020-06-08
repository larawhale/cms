<?php

namespace LaraWhale\Cms\Tests\Unit\Http\Requests\Concerns;

use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use LaraWhale\Cms\Http\Requests\Concerns\CopiesDotKeys;

class CopiesDotKeysTest extends TestCase
{
    /** @test */
    public function copies_dot_keys(): void
    {
        $mock = $this->getMockForTrait(CopiesDotKeys::class);

        $validator = Validator::make([], [
            'parent.child' => 'required',
        ]);

        $mock->withValidator($validator);

        $messages = $validator->messages();

        $this->assertSame(
            ['The parent.child field is required.'],
            $messages->get('parent[child]'),
        );
    }
}
