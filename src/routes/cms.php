<?php

use LaraWhale\Cms\Http\Controllers\EntryController;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
], function () {
    Route::resource('entries', EntryController::class, [
        'only' => ['store'],
    ]);
});
