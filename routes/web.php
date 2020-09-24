<?php

Auth::routes(['verify' => true]);

Route::group([
    'namespace' => 'Common'
], function() {
    Route::post('locale', 'LocalesController@switch')->name('locale');

    Route::group([
        'as' => 'locations.',
        'prefix' => 'locations'
    ], function() {
        Route::get('/', 'LocationsController@regions')->name('regions');
        Route::get('{region}', 'LocationsController@settlements')->name('settlements');
    });

    Route::group([
        'as' => 'category.',
        'prefix' => 'category'
    ], function (){
        Route::get('/', 'CategoriesController@categories')->name('categories');
        Route::get('{category}', 'CategoriesController@subcategories')->name('subcategories');
    });
});
