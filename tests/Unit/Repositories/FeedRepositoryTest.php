<?php
namespace Tests\Unit\Repositories;

use App\Models\Feed;
use App\Repositories\FeedRepository;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class FeedRepositoryTest extends TestCase
{
    /**
     * @var \App\Models\Feed $defaultFeed
     */
    private $defaultFeed;

    /**
     * @var \Mockery\Mock $model
     */
    private $model;

    public function setUp()
    {
        parent::setUp();

        $this->model = Mockery::mock(Feed::class);
        $this->defaultFeed = factory(Feed::class)->make();
    }

    /** @test */
    public function it_finds_by_name()
    {
        $feed = factory(Feed::class)->make(['name' => 'Some Feed']);

        $this->model->shouldReceive('by')->once()->with('Some Feed')->andReturnSelf()
                    ->shouldReceive('top')->once()->withNoArgs()->andReturnSelf()
                    ->shouldReceive('get')->once()->andReturn(collect([$feed]));

        $feeds = (new FeedRepository($this->model))->findByName('Some Feed');

        $this->assertInstanceOf(Collection::class, $feeds);
        $this->assertEquals('Some Feed', $feeds->first()->name);
    }

    /** @test */
    public function it_retrieves_all()
    {
        $this->model
            ->shouldReceive('all')
            ->once()
            ->withNoArgs()
            ->andReturn(collect([$this->defaultFeed]));

        $feeds = (new FeedRepository($this->model))->all();

        $this->assertInstanceOf(Collection::class, $feeds);
        $this->assertCount(1, $feeds);
    }

    /** @test */
    public function it_retrieves_by_id()
    {
        $feed = factory(Feed::class)->make(['id' => 1]);

        $this->model->shouldReceive('whereId')->once()->with(1)->andReturnSelf()
                    ->shouldReceive('get')->once()->andReturn($feed);

        $feed = (new FeedRepository($this->model))->findById(1);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals(1, $feed->id);
    }

    /** @test */
    public function it_retrieves_latest_feeds()
    {
        $this->model->shouldReceive('latest')->once()->with(1)->andReturnSelf()
                    ->shouldReceive('get')->once()->andReturn(collect([$this->defaultFeed]));

        $feeds = (new FeedRepository($this->model))->latests(1);

        $this->assertInstanceOf(Collection::class, $feeds);
        $this->assertCount(1, $feeds);
    }

    /** @test */
    public function it_retrieves_top_feeds()
    {
        $this->model->shouldReceive('top')->once()->with(1)->andReturnSelf()
                    ->shouldReceive('get')->once()->andReturn(collect([$this->defaultFeed]));

        $feeds = (new FeedRepository($this->model))->top(1);

        $this->assertInstanceOf(Collection::class, $feeds);
        $this->assertCount(1, $feeds);
    }

    /** @test */
    public function it_retrieves_total_episodes()
    {
        $this->model->shouldReceive('whereId')->once()->with(1)->andReturnSelf()
                    ->shouldReceive('select')->once()->with('total_episodes')->andReturnSelf()
                    ->shouldReceive('first')->once()->andReturnSelf()
                    ->shouldReceive('toArray')->once()->andReturn(['total_episodes' => 10]);

        $feed = (new FeedRepository($this->model))->totalEpisodes(1);

        $this->assertEquals(10, $feed['total_episodes']);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
