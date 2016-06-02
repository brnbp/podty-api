<?php

$version = '/v1';

Route::get(
    $version . '/',
    function() { return view('welcome'); }
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
