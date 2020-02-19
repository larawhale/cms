<?php

namespace LaraWhale\Cms\Tests;

use Spatie\Snapshots\MatchesSnapshots;
use LaraWhale\Cms\Providers\CmsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use MatchesSnapshots, MocksFormFacade;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockFormFacade();
    }

    /**
     * Returns the package providers.
     * 
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [CmsServiceProvider::class];
    }
}
