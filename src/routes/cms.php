<?php

use LaraWhale\Cms\Http\Controllers\EntryController;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => ['cms'],
], function () {
    Route::group([
        'middleware' => ['cms_guest'],
    ], function () {
        Route::get('login', function () {
            return 'GET:cms.login';
        })->name('login');

        Route::post('login', function () {
            return 'POST:cms.login';
        });
    });

    Route::group([
        'middleware' => ['cms_auth'],
    ], function () {
        Route::resource('entries', EntryController::class, [
            'except' => ['show'],
        ]);
    });
});
