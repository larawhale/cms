<?php

namespace LaraWhale\Cms\Tests;

use Orchestra\Testbench\BrowserKit\TestCase;

class BrowserTestCase extends TestCase
{
    use TestSetup;

    public $baseUrl = 'http://localhost';
}
