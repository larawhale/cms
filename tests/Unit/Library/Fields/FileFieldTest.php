<?php

namespace Tests\Unit\Library\Fields;

use Mockery;
use Illuminate\Http\UploadedFile;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use LaraWhale\Cms\Library\Fields\FileField;
use LaraWhale\Cms\Models\Entry as EntryModel;

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
    public function save(): void
    {
        Storage::fake();

        // Set a value so we can check that deleteFile is being called.
        $this->field->setValue('delete_me.jpg');

        $mock = Mockery::mock($this->field)->makePartial();

        $mock->shouldReceive('deleteFile');

        $entryModel = factory(EntryModel::class)->create();

        $file = UploadedFile::fake()->image('image.jpg');

        $mock->save($entryModel, $file);

        Storage::assertExists($mock->getValue());
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
        // Create a field instance without a config that contains a `file_paht`
        // key.
        $field = new FileField('test_key', 'file');

        $this->assertEquals(
            '',
            $field->getFilePath(),
        );
    }
}
