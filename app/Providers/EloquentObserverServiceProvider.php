<?php

namespace App\Providers;

use App\Models\Episode;
use App\Models\Feed;
use App\Models\FeedCategory;
use App\Models\User;
use App\Observer\EpisodeObserver;
use App\Observer\FeedCategoryObserver;
use App\Observer\FeedObserver;
use App\Observer\UserObserver;
use Illuminate\Support\ServiceProvider;

class EloquentObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Feed::observe(FeedObserver::class);
        Episode::observe(EpisodeObserver::class);
        FeedCategory::observe(FeedCategoryObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
