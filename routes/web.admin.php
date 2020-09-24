<?php

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'Admin'
], function () {
    Route::get('/', 'BoardController@index')->name('board');

    Route::resource('products', 'ProductsController')->middleware(['role:admin|moderator']);
    Route::resource('categories', 'CategoriesController')->middleware(['role:admin|moderator']);
    Route::resource('articles', 'ArticlesController')->middleware(['role:admin|writer']);
    Route::resource('units', 'UnitsController')->middleware(['role:admin|moderator']);

    Route::resource('orders', 'OrdersController')->only('index', 'show')->middleware(['role:admin|moderator']);

    Route::resource('tickets', 'TicketsController')->only('index', 'show')->middleware(['role:admin|moderator']);
    Route::post('tickets/{ticket}/answer', 'TicketsController@answer')->name('tickets.answer')->middleware(['role:admin|moderator']);
    Route::patch('tickets/{ticket}', 'TicketsController@handle')->name('tickets.handle')->middleware(['role:admin|moderator']);


    Route::resource('users', 'UsersController')->middleware(['role:admin']);
    Route::post('users/{user}/access', 'UsersController@access')->name('users.access')->middleware(['role:admin']);
    Route::get('export/users', 'UsersController@export')->name('users.export')->middleware(['role:admin']);

    Route::resource('pages', 'PagesController')->only('index', 'edit', 'update')->middleware(['role:admin|writer']);

    Route::group([
        'as' => 'settings.',
        'prefix' => 'settings',
        'middleware' => ['role:admin']
    ], function () {
        Route::get('/', 'SettingsController@index')->name('index');
        Route::patch('/', 'SettingsController@update')->name('update');
    });
});
