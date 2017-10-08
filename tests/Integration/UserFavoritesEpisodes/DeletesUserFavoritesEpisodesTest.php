<?php
namespace Tests\Integration\UserFavoritesEpisodes;

class DeletesUserFavoritesEpisodesTest extends UserFavoritesEpisodes
{
    /** @test */
    public function it_requires_authenticated_client_to_make_request()
    {
        $this->delete('/v1/users/randomuser/episodes/42/favorite')
            ->assertStatus(401);
    }

    /** @test */
    public function it_deletes_an_favorited_episode()
    {
        $this->authenticate();

        $this->post('/v1/users/' . $this->user->username . '/episodes/' . $this->episode->id . '/favorite');

        $this->delete('/v1/users/' . $this->user->username . '/episodes/' . $this->episode->id . '/favorite')
            ->assertStatus(200);
    }

    /** @test */
    public function it_cannot_deletes_unexistent_favorited_episode_for_user()
    {
        $this->authenticate();

        $this->delete('/v1/users/' . $this->user->username . '/episodes/1/favorite')
            ->assertStatus(404);
    }

    /** @test */
    public function it_cannot_deletes_favorited_episode_for_unexistent_user()
    {
        $this->authenticate();

        $this->post('/v1/users/notUser/episodes/' . $this->episode->id . '/favorite')
            ->assertStatus(404);
    }
}
