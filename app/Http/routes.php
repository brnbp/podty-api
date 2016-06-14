<?php

header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

Route::group(['middleware' => ['api']], function () {
    $version = '/v1';
    Route::get('/', function() { return view('welcome'); });
    Route::get($version . '/', function() { return view('welcome'); });

    // search feeds that recently post new episodes
    Route::get($version . '/feeds/latest','FeedController@latest');

    // search for podcast main informations from name
    Route::get($version . '/feeds/name/{name}','FeedController@retrieve');

    // search for podcast main informations from feedId
    Route::get($version . '/feeds/id/{feedId}','FeedController@retrieveById');

    // search for episodes from podcast id
    Route::get($version . '/episodes/feedId/{feedId}','EpisodeController@retrieve');

    Route::get($version . '/episodes/latest','EpisodeController@latest');



    Route::get(
        $version . '/users/{username}',
        'UserController@show'
    );
    Route::post(
        $version . '/user',
        function(){}
    );

    Route::get(
        $version . '/users/{username}/feeds',
        'UserController@showFeed'
    );


    Route::get(
        $version . '/users/{username}/feeds/{feedId}',
        'UserController@showEpisodes'
    );
    Route::get(
        $version . '/users/{username}/feeds/latests',
        'UserController@'
    );
    Route::get(
        $version . '/users/{username}/episodes/latests',
        'UserController@'
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
    Route::get($version . '/queue/failed', 'QueueController@failed');
});
