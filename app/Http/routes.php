<?php

Route::group(['prefix' => '/v1', 'middleware' => ['api']], function () {

    Route::get('feeds/latest', 'FeedController@latest');
    Route::get('feeds/top/{count?}', 'FeedController@top');
    Route::get('feeds/name/{name}', 'FeedController@retrieve');
    Route::get('feeds/{feed}', 'FeedController@retrieveById');
    Route::get('feeds/{feed}/episodes', 'EpisodeController@retrieve');

    Route::get('feeds/{feed}/listeners', 'FeedController@listeners');

    Route::get('episodes/latest', 'EpisodeController@latest');
    Route::get('episodes/{episode}', 'EpisodeController@one');

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

    Route::put('users/{user}/feeds/{feed}/listenAll', 'UserFeedsController@listenAll');

    Route::get('users/{username}/feeds/{feedId}/episodes', 'UserEpisodesController@show');
   
    Route::get('users/{username}/episodes/latests', 'UserEpisodesController@latests');
    Route::get('users/{username}/episodes/listening', 'UserEpisodesController@listening');
    Route::get('users/{username}/episodes/favorites', 'UserFavoriteController@all');
    
    Route::get('users/{user}/episodes/{episode}', 'UserEpisodesController@one');
    Route::post('users/{user}/episodes/{episode}', 'UserEpisodesController@attach');
    Route::delete('users/{user}/episodes/{episode}', 'UserEpisodesController@detach');
    Route::put('users/{user}/episodes/{episode}/paused/{time}', 'UserEpisodesController@paused');

    Route::post('users/{username}/episodes/{episodeId}/favorite', 'UserFavoriteController@favorite');
    Route::delete('users/{username}/episodes/{episodeId}/favorite', 'UserFavoriteController@unfavorite');


    Route::get('users/{user}/friends', 'UserFriendsController@all');

    Route::post('users/{user}/friends/{friend}', 'UserFriendsController@follow');
    Route::delete('users/{user}/friends/{friend}', 'UserFriendsController@unfollow');



    Route::get('queue', 'QueueController@index');
    Route::delete('queue/{id}', 'QueueController@destroy');
    Route::get('queue/failed', 'QueueController@failed');
});
