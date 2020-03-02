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
            'entry_type' => 'test_entry',
            'test_key' => 'test_key_value',
            'another_test_key' => 'another_test_key_value',
        ];

        $this->mockRequest($data['entry_type']);

        $validator = $this->makeValidator($data);

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function fails_required_type(): void
    {
        $validator = $this->makeValidator([]);

        $this->assertFalse($validator->passes());

        $this->assertEquals(
            'The entry type field is required.',
            $validator->errors()->first('entry_type'),
        );
    }

    /** @test */
    public function fails_required_type_exists(): void
    {
        $validator = $this->makeValidator([
            'entry_type' => 'non_existing',
        ]);

        $this->assertFalse($validator->passes());

        $this->assertEquals(
            'The selected entry type is invalid.',
            $validator->errors()->first('entry_type'),
        );
    }

    /** @test */
    public function fails_field(): void
    {
        $data = [
            'entry_type' => 'test_entry',
        ];

        $this->mockRequest($data['entry_type']);

        $validator = $this->makeValidator($data);

        $this->assertFalse($validator->passes());

        $this->assertEquals(
            'The test key field is required.',
            $validator->errors()->first('test_key'),
        );

        $this->assertEquals(
            'The another test key field is required.',
            $validator->errors()->first('another_test_key'),
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
            ->with('entry_type')
            ->andReturn($type);

        app()->instance('request', $request->getMock());
    }
}
