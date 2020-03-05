<?php

use LaraWhale\Cms\Http\Controllers\EntryController;
use Illuminate\Routing\Middleware\SubstituteBindings;

use LaraWhale\Cms\Models\Entry;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => [
        SubstituteBindings::class,
    ],
], function () {
    Route::resource('entries', EntryController::class, [
        'except' => ['destroy'],
    ]);
});
