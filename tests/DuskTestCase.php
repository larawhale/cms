<?php

namespace LaraWhale\Cms\Tests;

use Orchestra\Testbench\Dusk\Options;
use Orchestra\Testbench\Dusk\TestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class DuskTestCase extends TestCase
{
    use TestSetup;

    /**
     * The base serve host URL to use while testing the application.
     *
     * @var string
     */
    // protected static $baseServeHost = 'chrome';

    /**
     * The base serve port to use while testing the application.
     *
     * @var int
     */
    // protected static $baseServePort = 4444;

    /**
     * Setup the test environment.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // $this->withoutMockingConsoleOutput()
        //     ->artisan('migrate:fresh');
    }

    /**
 * Define environment setup.
 *
 * @param  Illuminate\Foundation\Application  $app
 *
 * @return void
 */
protected function getEnvironmentSetUp($app)
{
    parent::getEnvironmentSetUp($app);
    $app['config']->set('app.debug', true);
}

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--no-sandbox',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options,
            ),
        );
    }

    /** @test */
    public function browser_test(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/', ['type' => 'test_entry'])
                ->screenshot('test');
        });
    }
}
