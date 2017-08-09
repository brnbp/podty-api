<?php
namespace App\Providers;

use App\Events\AnalyticsEvent;
use App\Events\AnalyticsPageView;
use App\Listeners\GAEvent;
use App\Listeners\GAPageView;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AnalyticsEvent::class => [
            GAEvent::class,
        ],
        AnalyticsPageView::class => [
            GAPageView::class,
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
