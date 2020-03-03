<?php

namespace LaraWhale\Cms\Providers;

use LaraWhale\Cms\Models\Entry;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use LaraWhale\Cms\Library\Fields\Factory as FieldFactory;
use LaraWhale\Cms\Library\Entries\Factory as EntryFactory;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cms.php', 'cms');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadFactoriesFrom(__DIR__ . '/../../database/factories');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/cms.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'cms');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'cms');

        FieldFactory::$fields = config('cms.fields');

        EntryFactory::loadEntries();

        Route::model('entry', Entry::class);
    }
}
