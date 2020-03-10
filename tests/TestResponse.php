<?php

namespace LaraWhale\Cms\Tests;

use OwowAgency\LaravelTestResponse\TestResponse as BaseTestResponse;

class TestResponse extends BaseTestResponse
{
    /**
     * Asserts the response was redirected to login.
     * 
     * @return void
     */
    public function assertRedirectToLogin(): void
    {
        $this->assertRedirect('/cms/login');
    }
}
