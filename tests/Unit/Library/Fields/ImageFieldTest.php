<?php

namespace Tests\Unit\Library\Fields;

use Mockery;
use Illuminate\Http\UploadedImage;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use LaraWhale\Cms\Library\Fields\ImageField;
use LaraWhale\Cms\Models\Entry as EntryModel;

class ImageFieldTest extends TestCase
{
    /**
     * The ImageField instance used for testing.
     * 
     * @var \LaraWhale\Cms\Library\Fields\ImageField
     */
    private ImageField $field;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->field = new ImageField('test_key', 'file', [
            'preview_height' => '100px',
            'preview_width' => '100px',
        ]);
    }

    /** @test */
    public function render_input(): void
    {
        $this->assertMatchesHtmlSnapshot($this->field->renderInput());
    }

    /** @test */
    public function get_preview_height(): void
    {
        $this->assertEquals(
            '100px',
            $this->field->getPreviewHeight(),
        );
    }

    /** @test */
    public function get_preview_width(): void
    {
        $this->assertEquals(
            '100px',
            $this->field->getPreviewWidth(),
        );
    }
}
