<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type' );

Route::group(['prefix' => '/v1', 'middleware' => ['api']], function () {
    Route::get('/', function() { return view('welcome'); });
    Route::get('/', function() { return view('welcome'); });

    // search feeds that recently post new episodes
    Route::get('/feeds/latest', 'FeedController@latest');

    // search for podcast main informations from name
    Route::get('/feeds/name/{name}', 'FeedController@retrieve');

    // search for podcast main informations from feedId
    Route::get('/feeds/id/{feedId}', 'FeedController@retrieveById');

    // search for episodes from podcast id
    Route::get('/episodes/feedId/{feedId}', 'EpisodeController@retrieve');

    Route::get('/episodes/latest', 'EpisodeController@latest');



    Route::get('/users/{username}', 'UserController@show');
    Route::post('/user', function(){});

    Route::get('/users/{username}/feeds','UserController@showFeed');


    Route::get('/users/{username}/feeds/{feedId}', 'UserController@showEpisodes');
    Route::get('/users/{username}/feeds/latests', 'UserController@');
    Route::get('/users/{username}/episodes/latests', 'UserController@');


    Route::post('/users/feed', function(){});

    Route::post('/users/episodes', function(){});



    Route::get('/queue', 'QueueController@index');
    Route::delete('/queue/{id}', 'QueueController@destroy');
    Route::get('/queue/failed', 'QueueController@failed');
});
