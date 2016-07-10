<?php

DB::listen(function($query) {
    //var_dump($query->sql, $query->bindings);
});

Route::get('/', function() { return view('welcome'); });
Route::group(['prefix' => '/v1', 'middleware' => ['api']], function () {
    Route::get('/', function() { return view('welcome'); });

    Route::get('feeds/latest', 'FeedController@latest');
    Route::get('feeds/name/{name}', 'FeedController@retrieve');
    Route::get('feeds/id/{feedId}', 'FeedController@retrieveById');
    Route::get('episodes/feedId/{feedId}', 'EpisodeController@retrieve');
    Route::get('episodes/latest', 'EpisodeController@latest');


    Route::get('users/{username}', 'UserController@show');
    Route::post('users', 'UserController@create');
    Route::delete('users/{username}', 'UserController@delete');
    Route::post('users/authenticate', 'UserController@authenticate');

    Route::post('users/{username}/feeds', 'UserFeedsController@create');
    Route::delete('users/{username}/feeds/{feedId}', 'UserFeedsController@delete');
    Route::get('users/{username}/feeds','UserFeedsController@show');
    //Route::get('users/{username}/feeds/latests', 'UserFeedsController@latests');

    //Route::post('users/episodes', 'UserEpisodesController@create');
    //Route::get('users/{username}/feeds/{feedId}', 'UserEpisodesController@show');
    //Route::get('users/{username}/episodes/latests', 'UserEpisodesController@latests');


    Route::get('queue', 'QueueController@index');
    Route::delete('queue/{id}', 'QueueController@destroy');
    Route::get('queue/failed', 'QueueController@failed');
});
