<?php

namespace LaraWhale\Cms\Tests;

use ReflectionClass;
use Orchestra\Testbench\Dusk\TestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class DuskTestCase extends TestCase
{
    use TestSetup;

    /**
     * Figure out where the test directory is, if we're an included package, or the root one.
     *
     * @param string $path
     * @return string
     * @throws \Exception
     */
    protected function resolveBrowserTestsPath($path = __DIR__)
    {
        $reflection = new ReflectionClass($this);

        return dirname($reflection->getFilename());
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

    /**
     * Create a new Browser instance.
     *
     * @param  \Facebook\WebDriver\Remote\RemoteWebDriver  $driver
     * @return \Laravel\Dusk\Browser
     */
    protected function newBrowser($driver)
    {
        return new Browser($driver);
    }
}
