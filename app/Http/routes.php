<?php

Route::group(['prefix' => '/v1', 'middleware' => ['api']], function () {


    Route::get('feeds/latest', 'FeedController@latest');
    Route::get('feeds/top/{count?}', 'FeedController@top');
    Route::get('feeds/name/{name}', 'FeedController@retrieve');
    Route::get('feeds/id/{feedId}', 'FeedController@retrieveById');
    Route::get('episodes/feed/{feedId}', 'EpisodeController@retrieve');
    Route::get('episodes/latest', 'EpisodeController@latest');


    Route::get('/users/find/{term}', 'UserController@find');

    Route::get('users/{username}', 'UserController@show');
    Route::post('users', 'UserController@create');
    Route::delete('users/{username}', 'UserController@delete');
    Route::post('users/authenticate', 'UserController@authenticate');
    Route::patch('users/{username}/touch', 'UserController@touch');

    Route::post('users/{username}/feeds/{feedId}', 'UserFeedsController@attach');
    Route::delete('users/{username}/feeds/{feedId}', 'UserFeedsController@detach');

    Route::get('users/{username}/feeds','UserFeedsController@all');
    Route::get('users/{username}/feeds/{feedId}','UserFeedsController@one');

    Route::put('users/{username}/feeds/{feedId}/listenAll', 'UserFeedsController@listenAll');

    Route::get('users/{username}/episodes/feed/{feedId}', 'UserEpisodesController@show');
    Route::post('users/{username}/episodes', 'UserEpisodesController@attach');
    Route::delete('users/{username}/episodes/{episodeId}', 'UserEpisodesController@detach');
    Route::get('users/{username}/episodes/latests', 'UserEpisodesController@latests');

    Route::put('users/{username}/episodes/{episodeId}/paused/{time}', 'UserEpisodesController@paused');



    Route::get('users/{user}/followers', 'UserFriendsController@all');

    Route::post('users/{user}/follow/{friend}', 'UserFriendsController@follow');
    Route::delete('users/{user}/unfollow/{friend}', 'UserFriendsController@unfollow');



    Route::get('queue', 'QueueController@index');
    Route::delete('queue/{id}', 'QueueController@destroy');
    Route::get('queue/failed', 'QueueController@failed');
});
