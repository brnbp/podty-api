<?php
namespace Tests\Integration\Categories;

use App\Models\Category;
use App\Models\Feed;
use App\Models\FeedCategory;
use App\Transform\CategoryTransformer;
use App\Transform\FeedTransformer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveCategoriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_client_cannot_retrieve_episodes()
    {
        $this->get('/v1/categories')
            ->assertStatus(401);
    }

    /** @test */
    public function it_retrieves_all_categories()
    {
        $this->authenticate();

        $categories = create(Category::class, [], 2);

        $this->get('/v1/categories')
            ->assertExactJson([
                'data' => [
                    (new CategoryTransformer)->transform($categories->first()),
                    (new CategoryTransformer)->transform($categories->last()),
                ]
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_retrieves_zero_categories()
    {
        $this->authenticate();

        $response = $this->get('/v1/categories')
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true);

        $this->assertEquals([
            'data' => []
        ], $response);
    }

    /** @test */
    public function it_retrieves_one_category()
    {
        $this->authenticate();

        $categories = create(Category::class, [], 2);

        $response = $this->get('/v1/categories/' . $categories->first()->id)
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true);

        $expected = (new CategoryTransformer)->transform($categories->first());

        $this->assertEquals([
            'data' => $expected
        ], $response);
    }

    /** @test */
    public function it_returns_not_found_when_retrieving_inexistent_category()
    {
        $this->authenticate();

        create(Category::class);

        $this->get('/v1/categories/9999')
            ->assertStatus(404);
    }

    /** @test */
    public function it_retrieves_feeds_from_specific_category()
    {
        $this->authenticate();

        $category = create(Category::class);
        $feedOne = create(Feed::class);
        $feedTwo = create(Feed::class);

        create(FeedCategory::class, [
            'feed_id' => $feedTwo->id,
            'category_id' => $category->id
        ]);
        create(FeedCategory::class, [
            'feed_id' => $feedOne->id,
            'category_id' => $category->id
        ]);

        $response = $this->get('/v1/categories/' . $category->id . '/feeds')
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true);

        $expected = (new FeedTransformer())->transformMany([$feedOne, $feedTwo]);

        unset($expected[0]['episodes']);
        unset($expected[1]['episodes']);

        $this->assertEquals([
            'data' => $expected
        ], $response);
    }

    /** @test */
    public function it_retrieves_zero_feeds_from_specific_category()
    {
        $this->authenticate();

        $category = create(Category::class);

        create(FeedCategory::class, [], 2);

        $this->get('/v1/categories/' . $category->id . '/feeds')
            ->assertStatus(404);
    }
}
