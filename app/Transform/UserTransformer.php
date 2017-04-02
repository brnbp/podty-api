<?php
namespace App\Transform;

use Carbon\Carbon;

/**
 * Class FeedTransformer
 *
 * @package App\Transform
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transforma um feed para um retorno padrao
     * @param $user
     *
     * @return array
     */
    public function transform($user)
    {
        if (is_array($user)) {
            $user = (object) $user;
        }

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'friends_count' => $user->friends_count,
            'podcasts_count' => $user->podcasts_count,
            'joined_at' => $this->setDate($user->created_at),
            'last_update' => $this->setDate($user->updated_at)
        ];
    }

    private function setDate($date)
    {
        if (is_string($date)) {
            return $date;
        }

        return $date->toDateTimeString();
    }
}
