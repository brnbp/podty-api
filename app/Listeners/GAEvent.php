<?php
namespace App\Listeners;

use App\Events\AnalyticsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Irazasyed\LaravelGAMP\Facades\GAMP;

class GAEvent implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->gamp = GAMP::setClientId('1');
    }

    /**
     * Handle the event.
     *
     * @param  AnalyticsEvent  $event
     * @return void
     */
    public function handle(AnalyticsEvent $event)
    {
        $this->gamp->setEventCategory($event->category)
            ->setEventAction($event->action)
            ->sendEvent();
    }
}
