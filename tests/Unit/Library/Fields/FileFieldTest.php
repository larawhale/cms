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

        $this->field = new FileField('test_key', 'file');
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

        $this->field->setValue('delete_me.jpg');

        $mock = Mockery::mock($this->field)->makePartial();

        $mock->shouldReceive('deleteFile');

        $entryModel = factory(EntryModel::class)->create();

        $file = UploadedFile::fake()->image('image.jpg');

        $mock->save($entryModel, $file);

        Storage::assertExists($mock->getValue());
    }
}
