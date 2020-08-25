<?php

namespace Tests\Unit\Library\Fields;

use Mockery;
use Illuminate\Http\UploadedFile;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use LaraWhale\Cms\Library\Fields\FileField;

class FileFieldTest extends TestCase
{
    /**
     * The FileField instance used for testing.
     *
     * @var \LaraWhale\Cms\Library\Fields\FileField
     */
    private FileField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new FileField('test_key', 'file', [
            'file_path' => 'test_folder',
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
        $this->assertContains(
            'custom-file-input',
            $this->field->getInputClass(),
        );
    }

    /** @test */
    public function get_database_value(): void
    {
        Storage::fake();

        // Set a value so we can check that deleteFile is being called.
        $this->field->setValue('delete_me.jpg');

        $mock = Mockery::mock($this->field)->makePartial();

        $mock->shouldReceive('deleteFile');

        $file = UploadedFile::fake()->image('image.jpg');

        $path = $mock->getDatabaseValue($file);

        Storage::assertExists($path);
    }

    /** @test */
    public function get_file_path(): void
    {
        $this->assertEquals(
            'test_folder',
            $this->field->getFilePath(),
        );
    }

    /** @test */
    public function get_file_path_default(): void
    {
        // Create a field instance without a config that contains a `file_path`
        // key.
        $field = new FileField('test_key', 'file');

        $this->assertEquals(
            '',
            $field->getFilePath(),
        );
    }
}
