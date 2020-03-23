<?php

use LaraWhale\Cms\Models\Field;
use Illuminate\Support\Facades\Schema;
use LaraWhale\Cms\Http\Controllers\Controller;
use LaraWhale\Cms\Http\Controllers\EntryController;
use LaraWhale\Cms\Http\Controllers\LoginController;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => ['cms'],
], function () {
    Route::group([
        'middleware' => ['cms_guest'],
    ], function () {
        Route::get('login', [
            'as' => 'login',
            'uses' => LoginController::class . '@showLoginForm',
        ]);

        Route::post('login', LoginController::class . '@login');
    });

    Route::group([
        'middleware' => ['cms_auth'],
    ], function () {
        Route::post('logout', [
            'as' => 'logout',
            'uses' => LoginController::class . '@logout',
        ]);

        Route::get('', function () {
            // TODO: Should not be styleguide.
            return view('cms::styleguide.index');
        })->name('home');

        Route::resource('entries', EntryController::class, [
            'except' => ['show'],
        ]);
    });

    Route::fallback(Controller::class . '@fallback');
});

if (Schema::hasTable(cms_table_name('fields'))) {
    Field::type(config('cms.route_field_type'))
        ->with('entry')
        ->each(function (Field $field) {
            $entryClass = $field->entry->toEntryClass();

            Route::get($field->value, function () use ($entryClass) {
                return $entryClass->renderView();
            });
        });
}
