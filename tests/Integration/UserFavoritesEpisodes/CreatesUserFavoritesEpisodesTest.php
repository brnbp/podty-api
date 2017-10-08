<?php
namespace Tests\Integration\UserFavoritesEpisodes;

class CreatesUserFavoritesEpisodesTest extends UserFavoritesEpisodes
{
    /** @test */
    public function it_requires_authenticated_client_to_make_request()
    {
        $this->post('/v1/users/randomuser/episodes/42/favorite')
            ->assertStatus(401);
    }

    /** @test */
    public function it_favorites_an_episode()
    {
        $this->authenticate();

        $this->post('/v1/users/' . $this->user->username . '/episodes/' . $this->episode->id . '/favorite')
            ->assertStatus(201);
    }

    /** @test */
    public function it_cannot_favorites_an_unexistent_episode()
    {
        $this->authenticate();

        $this->post('/v1/users/' . $this->user->username . '/episodes/42/favorite')
            ->assertStatus(404);
    }

    /** @test */
    public function it_cannot_favorites_an_episode_for_unexistent_user()
    {
        $this->authenticate();

        $this->post('/v1/users/notUser/episodes/' . $this->episode->id . '/favorite')
            ->assertStatus(404);
    }
}
