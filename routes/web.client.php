<?php

Route::group([
    'as' => 'client.',
    'namespace' => 'Client'
], function () {
    Route::get('/', 'PagesController@home')->name('home');

    Route::group([
        'as' => 'products.',
        'prefix' => 'shop'
    ], function () {
        Route::get('/', 'ProductsController@index')->name('index');
        Route::get('{product}-{slug}', 'ProductsController@show')->name('show');
        Route::post('search', 'ProductsController@search')->name('search');
    });
    Route::group([
        'as' => 'carriers.',
        'prefix' => 'carriers'
    ], function () {
        Route::get('/', 'CarriersController@index')->name('index');
        Route::get('{carrier}-{slug}', 'CarriersController@show')->name('show');
        Route::post('search', 'CarriersController@search')->name('search');
    });

    Route::get('sellers/{seller}-{slug}', 'SellersController@show')->name('sellers.show');
    Route::group([
        'as' => 'news.',
        'prefix' => 'news'
    ], function () {
        Route::get('/', 'NewsController@index')->name('index');
        Route::get('{article}-{slug}', 'NewsController@show')->name('show');
    });

    Route::group([
        'as' => 'cart.',
        'prefix' => 'cart'
    ], function () {
        Route::get('/', 'CartsController@index')->name('index');
        Route::get('contents', 'CartsController@contents')->name('contents');
        Route::post('{product}', 'CartsController@add')->name('add');
        Route::patch('{product}/{cart}', 'CartsController@update')->name('update');
        Route::delete('{product}/{cart}', 'CartsController@destroy')->name('destroy');
    });

    Route::group([
        'as' => 'checkout.',
        'prefix' => 'checkout'
    ], function () {
        Route::get('/', 'CheckoutsController@index')->name('index');
        Route::post('store', 'CheckoutsController@store')->name('store');
        Route::get('{order}/success', 'CheckoutsController@success')->name('success');
    });

    Route::group([
        'as' => 'profile.',
        'prefix' => 'profile',
        'middleware' => ['auth']
    ], function () {
        Route::get('/', 'ProfilesController@index')->name('index');
        Route::get('history', 'ProfilesController@history')->name('history');
        Route::get('favorites', 'ProfilesController@favorites')->name('favorites');
        Route::patch('update', 'ProfilesController@update')->name('update');

        Route::resource('products', 'ProductsController')->middleware(['role:seller|admin|moderator']);
    });

    Route::post('favorites', 'FavoritesController@toggle')->name('favorites.toggle');
    Route::post('tickets', 'TicketsController@create')->name('tickets.create');
    Route::get('{page:slug}', 'PagesController@show')->name('pages.show');
});
