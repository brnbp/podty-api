<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
/** @var Faker\Generator $faker */


use App\Models\Episode;
use App\Models\Feed;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use App\Models\UserFriend;
use App\User;

$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('brnbp'),
        'remember_token' => md5('brnbp'),
        'friends_count' => 1,
        'podcasts_count' => 1
    ];
});

$factory->define(Feed::class, function (Faker\Generator $faker) {
    $name = $faker->words(3, true);
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'url' => $faker->url,
        'thumbnail_30' => $faker->imageUrl(),
        'thumbnail_60' => $faker->imageUrl(),
        'thumbnail_100' => $faker->imageUrl(),
        'thumbnail_600' => $faker->imageUrl(),
        'total_episodes' => $faker->numberBetween(10, 100),
        'listeners' => $faker->numberBetween(10, 100),
        'last_episode_at' => \Carbon\Carbon::now(),
    ];
});

$factory->define(Episode::class, function (Faker\Generator $faker) {
    return [
        'feed_id' => function(){
            return factory(Feed::class)->create();
        },
        'title' => $faker->words(3, true),
        'published_date' => $faker->dateTime,
        'summary' =>$faker->paragraphs(1, true),
        'content' => $faker->paragraphs(3, true),
        'image' => $faker->imageUrl(),
        'duration' => '02:30:42',
        'link' => $faker->url,
        'media_length' => $faker->numberBetween(11113960, 99993960),
        'media_type' => 'audio/mpeg',
        'media_url' => $faker->url,
    ];
});

$factory->define(UserFeed::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create();
        },
        'feed_id' => function(){
            return factory(Feed::class)->create();
        },
        'listen_all' => $faker->boolean(25),
    ];
});

$factory->define(UserEpisode::class, function (Faker\Generator $faker) {
    $feed = factory(Feed::class)->create();
    $episode = factory(Episode::class)->create([
        'feed_id' => $feed->id
    ]);
    $userFeed = factory(UserFeed::class)->create([
        'feed_id' => $feed->id
    ]);
    return [
        'user_feed_id' => $userFeed->id,
        'episode_id' => $episode->id,
        'paused_at' => $faker->randomNumber(6000),
    ];
});

$factory->define(UserFriend::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create();
        },
        'friends_user_id' => function(){
            return factory(User::class)->create();
        },
    ];
});

