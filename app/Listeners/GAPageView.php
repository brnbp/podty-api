<?php
namespace App\Listeners;

use App\Events\AnalyticsPageView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Irazasyed\LaravelGAMP\Facades\GAMP;

class GAPageView implements ShouldQueue
{
    public $gamp;
    
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
     * @param  AnalyticsPageView  $event
     * @return void
     */
    public function handle(AnalyticsPageView $event)
    {
        $this->gamp->setDocumentPath($event->path)
                ->setDocumentTitle($event->title)
                ->sendPageview();
    }
}
