<?php

namespace App\Transform;

/**
 * Class FeedTransformer.
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transforma um feed para um retorno padrao.
     *
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
            'id'             => $user->id,
            'username'       => $user->username,
            'email'          => $user->email,
            'friends_count'  => (int) $user->friends_count,
            'podcasts_count' => (int) $user->podcasts_count,
            'joined_at'      => $this->setDate($user->created_at),
            'last_update'    => $this->setDate($user->updated_at),
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
