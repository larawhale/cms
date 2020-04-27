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

        $this->field = new InputField([
            'key' => 'test_key',
            'type' => 'text',
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }

    /** @test */
    public function get_input_class(): void
    {
        // Mock a request to have a validation error on the key of the field.
        // This should result in an additional `is-invalid` class in the return
        // value of `getInputClass`.
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

        // Validat if the return value is correct.
        $this->assertEquals(
            'form-control is-invalid',
            $this->field->getInputClass(),
        );
    }
}
