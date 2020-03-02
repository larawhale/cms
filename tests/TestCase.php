<?php

namespace LaraWhale\Cms\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use TestSetup;

    /**
     * Setup the test environment.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMockingConsoleOutput()
            ->artisan('migrate:fresh');
    }
}
