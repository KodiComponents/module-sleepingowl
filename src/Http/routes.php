<?php

Route::group([
    'middleware' => config('sleeping_owl.middleware'),
    'prefix' => backend_url_segment().'/sleepingowl',
    'as' => 'admin.',
], function () {
    Route::get('{adminModel}', [
        'as'   => 'model',
        'uses' => 'AdminController@getDisplay',
    ]);

    Route::get('{adminModel}/create', [
        'as'   => 'model.create',
        'uses' => 'AdminController@getCreate',
    ]);

    Route::post('{adminModel}', [
        'as'   => 'model.store',
        'uses' => 'AdminController@postStore',
    ]);

    Route::get('{adminModel}/{adminModelId}/edit', [
        'as'   => 'model.edit',
        'uses' => 'AdminController@getEdit',
    ]);

    Route::post('{adminModel}/{adminModelId}', [
        'as'   => 'model.update',
        'uses' => 'AdminController@postUpdate',
    ]);

    Route::delete('{adminModel}/{adminModelId}', [
        'as'   => 'model.destroy',
        'uses' => 'AdminController@postDestroy',
    ]);

    Route::post('{adminModel}/{adminModelId}/restore', [
        'as'   => 'model.restore',
        'uses' => 'AdminController@postRestore',
    ]);

    Route::get('{adminWildcard}', [
        'as'   => 'wildcard',
        'uses' => 'AdminController@getWildcard',
    ]);
});
