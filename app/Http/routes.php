<?php

$version = '/v1';
Route::get('/', function() { return view('welcome'); });
Route::get(
    $version . '/',
    function() { return view('welcome'); }
);

// search feeds that recently post new episodes
Route::get(
    $version . '/feeds/latest',
    'FeedController@latest'
);

// search for podcast main informations
Route::get(
    $version . '/feeds/name/{name}',
    'FeedController@retrieve'
);

// search for episodes from podcast id
Route::get(
    $version . '/episodes/feedId/{feedId}',
    'EpisodeController@retrieve'
    );

Route::get(
    $version . '/episodes/latest',
    'EpisodeController@latest'
);

Route::post(
    $version . '/user',
    function(){}
);

Route::get(
    $version . '/users/{username}',
    'UserController@show'
);

Route::get(
    $version . '/users/{username}/feeds',
    'UserController@showFeed'
);

Route::get(
    $version . '/users/{username}/feeds/{feedId}',
    'UserController@showEpisodes'
);

Route::post(
    $version . '/users/feed',
    function(){}
);
Route::post(
    $version . '/users/episodes',
    function(){}
);


Route::get($version . '/queue', 'QueueController@index');
Route::delete($version . '/queue/{id}', 'QueueController@destroy');
Route::get($version . '/queue/reserved', 'QueueController@reserved');


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
