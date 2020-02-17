<?php

use LaraWhale\Cms\TestClass;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCaseTest extends BaseTestCase
{
    /** @test */
    public function my_first_test(): void
    {
        $testClass = new TestClass;

        $this->assertInstanceOf(TestClass::class, $testClass);
    }
}
