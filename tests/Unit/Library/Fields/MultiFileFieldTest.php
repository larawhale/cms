<?php

namespace Tests\Unit\Library\Fields;

use Mockery;
use Illuminate\Http\UploadedFile;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use LaraWhale\Cms\Library\Fields\FileField;
use LaraWhale\Cms\Library\Fields\MultiFileField;

class MultiFileFieldTest extends TestCase
{
    /**
     * The MultiFileField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\MultiFileField
     */
    private MultiFileField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new MultiFileField('test_key', 'file');
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }

    /** @test */
    public function get_input_id(): void
    {
        $this->assertEquals(
            'test_key[]',
            $this->field->getInputId(),
        );
    }

    /** @test */
    public function get_database_value(): void
    {
        Storage::fake();

        $currentValue = ['file_1.jpg'];

        $newFile = UploadedFile::fake()->image('new.jpg');

        $newValue = [1 => $newFile];

        $fieldInstances = [
            (new FileField(0, ''))->setValue('file_1.jpg'),
            (new FileField(1, ''))->setValue(null),
        ];

        $combinedValue = $currentValue + [1 => null];

        $mock = $this->partialMock(MultiFileField::class, function ($m) use ($combinedValue, $fieldInstances) {
            $m->shouldReceive('getFileFieldInstances')
                ->once()
                ->with($combinedValue)
                ->andReturn($fieldInstances);
        });

        $mock->setValue($currentValue);
        
        $databaseValue = json_decode($mock->getDatabaseValue($newValue));

        $this->assertEquals('file_1.jpg', $databaseValue[0]);

        $this->assertStringEndsWith('new.jpg', $databaseValue[1]);

        $this->assertCount(2, $databaseValue);

        Storage::assertExists($databaseValue[1]);
    }

    /** @test */
    public function get_database_value_deletes_old_file(): void
    {
        Storage::shouldReceive('delete')
            ->once()
            ->with('delete_me.jpg');

        $this->field->setValue(['delete_me.jpg']);
        
        $databaseValue = json_decode($this->field->getDatabaseValue([null]));

        $this->assertEquals([], $databaseValue);
    }

    /** @test */
    public function get_file_field_instances(): void
    {
        $value = [
            'file_1.jpg',
            'file_2.jpg',
        ];

        $this->field->setValue($value);

        $instances = $this->field->getFileFieldInstances();

        foreach ($instances as $key => $instance) {
            $this->assertInstanceOf(FileField::class, $instance);

            $this->assertSame($instance->getValue(), $value[$key]);
        }
    }

    /** @test */
    public function get_file_field_instances_spefified_value(): void
    {
        $value = [
            'file_1.jpg',
            UploadedFile::fake()->image('new.jpg'),
        ];

        $instances = $this->field->getFileFieldInstances($value);

        foreach ($instances as $key => $instance) {
            $this->assertInstanceOf(FileField::class, $instance);

            $this->assertSame($instance->getValue(), $value[$key]);
        }
    }
}
