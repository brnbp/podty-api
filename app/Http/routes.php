<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

DB::listen(function($query) {
    //var_dump($query->sql, $query->bindings);
});

Route::get('/test', function(){

    $feed = (new \App\Repositories\FeedRepository())->latests(1);

    (new \App\Models\Episode)->storage($feed->first()->id, $feed->first()->url);

});


Route::get('/', function() { return view('welcome'); });
Route::group(['prefix' => '/v1', 'middleware' => ['api']], function () {
    Route::get('/', function() { return view('welcome'); });

    Route::get('feeds/latest', 'FeedController@latest');
    Route::get('feeds/name/{name}', 'FeedController@retrieve');
    Route::get('feeds/id/{feedId}', 'FeedController@retrieveById');
    Route::get('episodes/feed/{feedId}', 'EpisodeController@retrieve');
    Route::get('episodes/latest', 'EpisodeController@latest');

    Route::get('users/{username}', 'UserController@show');
    Route::post('users', 'UserController@create');
    Route::delete('users/{username}', 'UserController@delete');
    Route::post('users/authenticate', 'UserController@authenticate');

    Route::post('users/{username}/feeds', 'UserFeedsController@attach');
    Route::delete('users/{username}/feeds/{feedId}', 'UserFeedsController@detach');
    Route::get('users/{username}/feeds','UserFeedsController@all');
    Route::get('users/{username}/feeds/{feedId}','UserFeedsController@one');


    Route::get('users/{username}/episodes/feed/{feedId}', 'UserEpisodesController@show');
    Route::post('users/{username}/episodes/feed/{feedId}', 'UserEpisodesController@attach');
    Route::delete('users/{username}/episodes/{episodeId}', 'UserEpisodesController@detach');
    Route::get('users/{username}/episodes/latests', 'UserEpisodesController@latests');


    Route::put('users/{username}/episodes/');






    Route::post('users/{username}/friends/{friendId}', 'UserFriends@attach');
    Route::delete('users/{username}/friends/{friendId}', 'UserFriends@detach');
    Route::get('users/{username}/friends', 'UserFriends@all');









    Route::get('queue', 'QueueController@index');
    Route::delete('queue/{id}', 'QueueController@destroy');
    Route::get('queue/failed', 'QueueController@failed');
});
