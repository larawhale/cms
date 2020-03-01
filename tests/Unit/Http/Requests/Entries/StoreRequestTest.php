<?php

use Illuminate\Http\Request;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use LaraWhale\Cms\Http\Requests\Entries\StoreRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorInterface;

class StoreRequestTest extends TestCase
{
    /** @test */
    public function succeeds(): void
    {
        $data = [
            'type' => 'test_entry',
            'fields' => [
                'test_key' => 'test_key_value',
            ],
        ];

        $this->mockRequest($data['type']);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function fails_required_type(): void
    {
        $validator = $this->makeValidator([]);

        $this->assertFalse($validator->passes());

        $this->assertEquals(
            'The type field is required.',
            $validator->errors()->first('type'),
        );
    }

    /** @test */
    public function fails_required_type_exists(): void
    {
        $validator = $this->makeValidator([
            'type' => 'non_existing',
        ]);

        $this->assertFalse($validator->passes());

        $this->assertEquals(
            'The selected type is invalid.',
            $validator->errors()->first('type'),
        );
    }

    /** @test */
    public function fails_field(): void
    {
        $data = [
            'type' => 'test_entry',
        ];

        $this->mockRequest($data['type']);

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->passes());

        $this->assertEquals(
            'The fields.test key field is required.',
            $validator->errors()->first('fields.test_key'),
        );
    }

    /**
     * Makes a validator instance with the store request rules and specified
     * data.
     * 
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function makeValidator(array $data): ValidatorInterface
    {
        return Validator::make(
            $data,
            (new StoreRequest)->rules(),
        );
    }

    /**
     * Mocks the request.
     *
     * @param  string  $type
     * @return void
     */
    private function mockRequest(string $type): void
    {
        $request = Mockery::mock(Request::class)
            ->makePartial()
            ->shouldReceive('get')
            ->with('type')
            ->andReturn($type);

        app()->instance('request', $request->getMock());
    }
}
