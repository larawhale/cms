<?php

namespace LaraWhale\Cms\Tests;

use OwowAgency\LaravelTestResponse\TestResponse as BaseTestResponse;

class TestResponse extends BaseTestResponse
{
    /**
     * Asserts the response was redirected to login.
     *
     * @return self
     */
    public function assertRedirectLogin(): self
    {
        return $this->assertRedirect('/cms/login');
    }

    /**
     * Asserts the response was redirected to home.
     *
     * @return self
     */
    public function assertRedirectHome(): self
    {
        return $this->assertRedirect('/cms');
    }
}
