<?php

Route::get('/', function () {
    return view('welcome');
});

// inclui podcast em feeds
Route::post('/name/{name}', 'FeedController@create');

// busca episodios a partir do nome do podcast
Route::get('/name/{name}', 'EpisodeController@retrieve');



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
