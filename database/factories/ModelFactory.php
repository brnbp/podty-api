<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
/** @var Faker\Generator $faker */


use App\Models\Episode;
use App\Models\Feed;
use App\Models\Rating;
use App\Models\User;
use App\Models\UserEpisode;
use App\Models\UserFeed;
use App\Models\UserFriend;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'username' => str_random(8),
        'email' => $faker->email,
        'password' => $faker->password(8, 12),
        'remember_token' => $faker->password(8, 12),
        'friends_count' => 0,
        'podcasts_count' => 0
    ];
});

$factory->define(Feed::class, function (Faker\Generator $faker) {
    $name = $faker->words(3, true);
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'url' => $faker->url,
        'description' => $faker->words(5, true),
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
        'feed_id' => function () {
            return factory(Feed::class)->create()->id;
        },
        'title' => $faker->words(3, true),
        'published_date' => \Carbon\Carbon::now()->subDay(random_int(1, 5)),
        'summary' =>$faker->paragraphs(1, true),
        'content' => $faker->paragraphs(2, true),
        'image' => $faker->imageUrl(),
        'duration' => '02:30:42',
        'link' => $faker->url,
        'media_length' => $faker->numberBetween(113960, 993960),
        'media_type' => 'audio/mpeg',
        'media_url' => $faker->url,
    ];
});

$factory->define(UserFeed::class, function () {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'feed_id' => function () {
            return factory(Feed::class)->create()->id;
        },
        'listen_all' => false,
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
        'paused_at' => $faker->randomNumber(3),
    ];
});

$factory->define(UserFriend::class, function () {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'friend_user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(Rating::class, function () {
    $content = rand(0, 1) == 1 ?
                    factory(Episode::class)->create() :
                    factory(Feed::class)->create();
    return [
        'content_type' => function () use ($content) {
            return ($content instanceof Episode) ? Episode::class : Feed::class;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'content_id' => $content->id,
    ];
});
