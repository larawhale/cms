<?php

namespace LaraWhale\Cms\Tests;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Spatie\Snapshots\MatchesSnapshots;
use Collective\Html\HtmlServiceProvider;
use LaraWhale\Cms\Providers\CmsServiceProvider;

class PublishedVendor
{
    public static $published = false;
}

trait TestSetup
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

        if (! PublishedVendor::$published) {
            $this->withoutMockingConsoleOutput()
                ->artisan('vendor:publish', [
                    '--force' => true,
                    '--tag' => 'cms',
                ]);

            PublishedVendor::$published = true;
        }
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.debug', true);

        $app['config']->set('app.key', 'base64:jP6O/1z8UfmxYf+PeiNubQRH+WstpxYTa1jGaTuLzgc=');

        $app['config']->set('app.url', 'http://127.0.0.1:8000');

        $app['config']->set('auth.defaults.guard', 'cms');

        $app['config']->set('database.connections.testing', [
            'driver' => 'mysql',
            'url' => null,
            'host' => 'mysql',
            'port' => '3306',
            'database' => 'forge',
            'username' => 'forge',
            'password' => 'forge',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ]);

        $app['config']->set('database.default', 'testing');

        $app['config']->set('filesystems.default', 'cms');

        $app['config']->set('filesystems.disks.cms', [
            'driver' => 'local',
            'root' => __DIR__ . '/storage',
            'url' => env('APP_URL') . '/tests/storage',
            'visibility' => 'public',
        ]);

        $app['config']->set(
            'cms.entries.path',
            __DIR__ . '/Support/Entries/',
        );

        $app['config']->prepend(
            'view.paths',
            __DIR__ . '/Support/views/',
        );

        // Add additional translations. Make locale something different than
        // the default `cms`, somehow the translator does not want to load the
        // original translations anymore.
        $app['translator']->addLines(
            require __DIR__ . '/Support/lang.php',
            'testing',
            'cms',
        );

        $app['translator']->setFallback('testing');
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
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Form' => FormFacade::class,
            'Html' => HtmlFacade::class,
        ];
    }

    /**
     * Create the test response instance from the given response.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return \LaraWhale\Cms\Tests\TestResponse
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
    protected function assertDatabaseHas($table, array $data, $connection = null): self
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
    protected function assertDatabaseMissing($table, array $data, $connection = null): self
    {
        return parent::assertDatabaseMissing(cms_table_name($table), $data);
    }
}
