<?php
namespace App\Http\Controllers;

use App\Repositories\UserFeedsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Input;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserFeedsController extends ApiController
{
    /**
     * Get all feeds from specific user
     * @param string $username
     */
    public function all($username)
    {
        return $this->responseData(UserFeedsRepository::all($username));
    }

    public function one($username, $feedId)
    {
        return $this->responseData(UserFeedsRepository::one($username, $feedId));
    }

    public function create($username)
    {
        $user = UserRepository::first($username);
        if (!$user) {
            return $this->respondNotFound();
        }
        
        if (!Input::get('feeds')) {
            return $this->respondBadRequest();
        }

        UserFeedsRepository::batchCreate(Input::get('feeds'), $user);
    }

    public function delete($username, $feedId)
    {
        $user = UserRepository::first($username);
        if (!$user) {
            return $this->respondNotFound();
        }
        return UserFeedsRepository::delete($feedId, $user) ?
            $this->respondSuccess(['removed' => true]) : $this->respondNotFound();
    }

    private function responseData($data)
    {
        return empty($data) ? $this->respondNotFound() : $this->respondSuccess($data);
    }
}
