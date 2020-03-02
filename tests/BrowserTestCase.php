<?php

namespace LaraWhale\Cms\Tests;

use Orchestra\Testbench\BrowserKit\TestCase;

class BrowserTestCase extends TestCase
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

        $this->artisan('migrate:fresh');
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
        return $this->seeInDatabase(cms_table_name($table), $data, $connection);
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
        return $this->notSeeInDatabase(cms_table_name($table), $data, $connection);
    }
}
