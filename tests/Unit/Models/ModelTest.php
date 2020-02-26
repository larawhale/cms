<?php

namespace LaraWhale\Cms\Tests\Unit\Models;

use LaraWhale\Cms\Models\Model;
use LaraWhale\Cms\Tests\TestCase;
use Illuminate\Database\Eloquent\Model as EloquenModel;

class ModelTest extends TestCase
{
    /** @test */
    public function get_table(): void
    {
        $model = new Model();

        $this->assertEquals(
            'cms_models',
            $model->getTable(),
        );
    }

    /** @test */
    public function get_table_prefixes_once(): void
    {
        $model = new Model();

        $model->setTable('cms_models');

        $this->assertEquals(
            'cms_models',
            $model->getTable(),
        );
    }
}
