<?php

namespace Tests\Unit\Library\Fields;

use Mockery;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\MessageBag;
use LaraWhale\Cms\Library\Fields\InputField;

class InputFieldTest extends TestCase
{
    /**
     * The InputField instance used for testing.
     * 
     * @var \LaraWhale\Cms\Library\Fields\InputField
     */
    private InputField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new InputField('test_key', 'text', [
            'input_attributes' => ['placeholder' => 'test_placeholder'],
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }

    /** @test */
    public function get_input_attributes(): void
    {
        $this->assertSame(
            [
                'id' => 'test_key',
                'placeholder' => 'test_placeholder',
                'class' => ['form-control'],
            ],
            $this->field->getInputAttributes(),
        );
    }

    /** @test */
    public function get_input_attributes_overwrites(): void
    {
        // Create a field with an id key, it should overwrite the default id.
        $field = new InputField('test_key', 'text', [
            'input_attributes' => ['id' => 'test_id'],
        ]);

        $this->assertSame(
            [
                // Id is overwritten.
                'id' => 'test_id',
                'class' => ['form-control'],
            ],
            $field->getInputAttributes(),
        );
    }

    /** @test */
    public function get_input_class(): void
    {
        $this->assertSame(
            ['form-control'],
            $this->field->getInputClass(),
        );
    }

    /** @test */
    public function get_input_class_appends(): void
    {
        // Create a field with a `class` configured in the `input_attributes`.
        // This configured class should be in the return value of
        // `getInputClass`.
        $field = new InputField('test_key', 'text', [
            'input_attributes' => ['class' => ['test_class']],
        ]);

        $this->assertSame(
            ['test_class', 'form-control'],
            $field->getInputClass(),
        );
    }

    /** @test */
    public function get_input_class_appends_string(): void
    {
        // Create a field with a `class` configured in the `input_attributes`.
        // The value of this `class` is a string that contains multiple
        // classes. This configured class should be in the return value of
        // `getInputClass`.
        $field = new InputField('test_key', 'text', [
            'input_attributes' => ['class' => 'class_one class_two'],
        ]);

        $this->assertSame(
            ['class_one', 'class_two', 'form-control'],
            $field->getInputClass(),
        );
    }

    /** @test */
    public function get_input_class_invalid_input(): void
    {
        $this->mockFailedRequest();

        // The input class should contain the `is-invalid` class when the
        // request has an error on the field key.
        $this->assertEquals(
            ['form-control', 'is-invalid'],
            $this->field->getInputClass(),
        );
    }

    /** @test */
    public function get_input_id(): void
    {
        $field = new InputField('test_key', 'text', [
            'input_attributes' => ['id' => 'test_id'],
        ]);

        $this->assertEquals(
            'test_id',
            $field->getInputId(),
        );
    }

    /** @test */
    public function get_input_id_default(): void
    {
        $this->assertEquals(
            // The `getInputId` method should fallback to the field key.
            'test_key',
            $this->field->getInputId(),
        );
    }

    /** @test */
    public function input_is_invalid(): void
    {
        $this->mockFailedRequest();

        $this->assertTrue($this->field->inputIsInvalid());
    }

    /** @test */
    public function input_is_valid(): void
    {
        $this->assertFalse($this->field->inputIsInvalid());
    }

    /**
     * Mocks a request that has an error on the field key.
     * 
     * @return void
     */
    private function mockFailedRequest(): void
    {
        $session = Mockery::mock(Store::class)
            ->makePartial()
            ->shouldReceive('get')
            ->with('errors')
            ->andReturn(new MessageBag([
                $this->field->getKey() => 'Erroreeeee!!1!',
            ]));

        $request = Mockery::mock(Request::class)
            ->makePartial();

        $request->shouldReceive('hasSession')
            ->andReturn(true);

        $request->shouldReceive('session')
            ->andReturn($session->getMock());

        app()->instance('request', $request);
    }
}
