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
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

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
        $this->queue = 'low';
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
                $feed->main_color = $this->retrieveMainColorFromImage($feed->thumbnail_100);
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

    public function retrieveMainColorFromImage(string $image): string
    {
        $palette = Palette::fromFilename($image);

        $extractor = new ColorExtractor($palette);

        $color = collect($extractor->extract(1))
                    ->map(function ($color) {
                        return Color::fromIntToHex($color);
                    });

        return $color->first();
    }
}
