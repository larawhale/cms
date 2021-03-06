<?php

use LaraWhale\Cms\Models\Field;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use LaraWhale\Cms\Http\Controllers\Controller;
use LaraWhale\Cms\Http\Middleware\TrimNullValues;
use LaraWhale\Cms\Http\Controllers\EntryController;
use LaraWhale\Cms\Http\Controllers\LoginController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use LaraWhale\Cms\Http\Middleware\NullifyFilesToRemove;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => [
        'cms',
        TrimNullValues::class,
        // It is important that the `NullifyFilesToRemove` is after the
        // `TrimNullValues` because it will add `null` values back to the
        // request for files that should be removed.
        NullifyFilesToRemove::class,
    ],
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


// The database might not be present on installation. This check is necessary
// to prevent console commands from not working anymore, even
// "post-autoload-dump" depends on this.
$hasFieldsTable = false;

try {
    $hasFieldsTable = Schema::hasTable(cms_table_name('fields'));
} catch (QueryException $e) {
    if (! app()->runningInConsole()) {
        throw $e;
    } else {
        Log::error($e->getMessage());
    }
}

if ($hasFieldsTable) {
    Field::type(config('cms.fields.route_field_type'))
        ->with('entry')
        ->each(function (Field $field) {
            $entryClass = $field->entry->toEntryClass();

            Route::get($field->value, function () use ($entryClass) {
                return $entryClass->renderView();
            });
        });
}
