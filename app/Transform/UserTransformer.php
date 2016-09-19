<?php
namespace App\Transform;

/**
 * Class FeedTransformer
 *
 * @package App\Transform
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transforma um feed para um retorno padrao
     * @param $feed
     *
     * @return array
     */
    public function transform($user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'friends_count' => $user->friends_count,
            'podcasts_count' => $user->podcasts_count,
            'joined_at' => $user->created_at->toDateTimeString(),
            'last_update' => $user->updated_at->toDateTimeString()
        ];

    }
}
