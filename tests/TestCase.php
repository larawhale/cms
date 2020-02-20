<?php

namespace LaraWhale\Cms\Tests;

use Spatie\Snapshots\MatchesSnapshots;
use Collective\Html\HtmlServiceProvider;
use LaraWhale\Cms\Providers\CmsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use MatchesSnapshots;

    /**
     * Returns the package providers.
     * 
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            CmsServiceProvider::class,
            HtmlServiceProvider::class,
        ];
    }
}
