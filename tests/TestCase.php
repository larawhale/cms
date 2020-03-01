<?php

namespace LaraWhale\Cms\Tests;

use Spatie\Snapshots\MatchesSnapshots;
use Collective\Html\HtmlServiceProvider;
use LaraWhale\Cms\Providers\CmsServiceProvider;
use OwowAgency\LaravelTestResponse\TestResponse;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use MatchesSnapshots;

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

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set(
            'cms.entries_path',
            __DIR__ . '/Support/Entries/',
        );
    }

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

    /**
     * Create the test response instance from the given response.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function createTestResponse($response)
    {
        return TestResponse::fromBaseResponse($response);
    }

    /**
     * Assert that a given where condition exists in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string|null  $connection
     * @return $this
     */
    protected function assertDatabaseHas($table, array $data, $connection = null): BaseTestCase
    {
        return parent::assertDatabaseHas(cms_table_name($table), $data);
    }

    /**
     * Assert that a given where condition does not exist in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string|null  $connection
     * @return $this
     */
    protected function assertDatabaseMissing($table, array $data, $connection = null): BaseTestCase
    {
        return parent::assertDatabaseMissing(cms_table_name($table), $data);
    }
}
