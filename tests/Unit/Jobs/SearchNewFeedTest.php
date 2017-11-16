<?php
namespace Tests\Unit\Jobs;

use App\Jobs\SearchNewFeed;
use App\Models\Feed;
use App\Repositories\FeedRepository;
use App\Services\Itunes\Finder;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SearchNewFeedTest extends TestCase
{
    /** @test */
    public function it_finds_new_feeds()
    {
        $feed = factory(Feed::class)->make(['name' => 'newest feed']);

        $finder = \Mockery::mock(Finder::class);
        $finder->shouldReceive('all')->with('newest feed')->andReturn([$feed->toArray()]);

        $repository = \Mockery::mock(FeedRepository::class);
        $repository->shouldReceive('updateOrCreate')->once()->with($feed->toArray())->andReturn(collect($feed));

        $search = new SearchNewFeed('newest feed');

        $feeds = $search->handle($repository, $finder);

        $this->assertCount(1, $feeds);
        $this->assertInstanceOf(Collection::class, $feeds);
    }
}
