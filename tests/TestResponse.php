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
    public function assertRedirectLogin(): void
    {
        $this->assertRedirect('/cms/login');
    }

    /**
     * Asserts the response was redirected to home.
     * 
     * @return void
     */
    public function assertRedirectHome(): void
    {
        $this->assertRedirect('/cms');
    }
}
