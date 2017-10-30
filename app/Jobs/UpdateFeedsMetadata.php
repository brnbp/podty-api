<?php
namespace App\Jobs;

use App\Models\Category;
use App\Models\Feed;
use App\Models\FeedCategory;
use App\Services\Parser\XML;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateFeedsMetadata implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    /**
     * @var \Illuminate\Support\Collection $feed
     */
    public $feeds;

    public function __construct(Feed $feed = null)
    {
        $this->feeds = collect([$feed])->filter();
    }

    public function handle(XML $xml)
    {
        if ($this->feeds->isEmpty()) {
            $this->feeds = Feed::all();
        }

        $this->feeds->each(function ($feed) use ($xml) {
            $content = $xml->retrieve($feed->url);
            if (!$content) {
                return;
            }

            $this->saveCategories($xml, $content, $feed);

            try {
                $feed->description = $xml->getDescription($content);
                $feed->save();
            } catch (\Exception $e) {
                return;
            }
        });
    }

    public function saveCategories($xml, $content, $feed)
    {
        $xml->getCategories($content)->each(function ($category) use ($feed) {
            $category = Category::firstOrCreate([
                'slug' => str_slug($category),
                'name' => $category,
            ]);

            FeedCategory::firstOrCreate([
                'feed_id' => $feed->id,
                'category_id' => $category->id,
            ]);
        });
    }
}
