<?php
namespace App\Jobs;

use App\Models\Feed;
use App\Services\Parser\XML;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateFeedsMetadata implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function handle(XML $xml)
    {
        $feeds = Feed::all();

        $feeds->each(function($feed) use($xml) {

            $content = $xml->retrieve($feed->url);
            if (!$content) {
                return;
            }

            try {
                $feed->description = $xml->getDescription($content);
                $feed->save();
            } catch (\Exception $e) {
                return;
            }

        });
    }
}
