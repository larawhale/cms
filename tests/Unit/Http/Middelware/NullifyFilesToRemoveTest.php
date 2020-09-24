<?php

namespace LaraWhale\Cms\Tests\Unit\Http\Middleware;

use Illuminate\Http\Request;
use LaraWhale\Cms\Tests\TestCase;
use LaraWhale\Cms\Http\Middleware\NullifyFilesToRemove;

class NullifyFilesToRemoveTest extends TestCase
{
    /** @test */
    public function nullifies_files_to_remove(): void
    {
        $request = new Request([], [
            'remove' => 'remove',
            'no_file' => 'remove',
        ]);

        $_FILES['remove'] = 'some file';

        $_FILES['dont_remove'] = 'some file';

        (new NullifyFilesToRemove)->handle($request, function ($request) {
            $this->assertSame(
                [
                    'remove' => null,
                    'no_file' => 'remove',
                ],
                $request->request->all()
            );
        });
    }
}
