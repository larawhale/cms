<?php

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
        Route::resource('entries', EntryController::class, [
            'except' => ['show'],
        ]);
    });
});
