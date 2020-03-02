<?php

namespace LaraWhale\Cms\Tests;

use Orchestra\Testbench\BrowserKit\TestCase;

class BrowserTestCase extends TestCase
{
    use TestSetup;

    /**
     * The base url used by browser kit.
     * 
     * @var string
     */
    public $baseUrl = 'http://localhost';
}
