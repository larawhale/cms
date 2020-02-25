<?php

namespace LaraWhale\Cms\Providers;

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

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'cms');

        FieldFactory::$fields = config('cms.fields');

        EntryFactory::loadEntries();
    }
}
