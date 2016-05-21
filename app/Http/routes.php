<?php

Route::get('/', function () {
    return view('welcome');
});

// search for podcast main informations
Route::get('/feed/{name}', 'FeedController@retrieve');

// search for episodes from podcast id
Route::get('/episodes/{feedId}', 'EpisodeController@retrieve');

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
