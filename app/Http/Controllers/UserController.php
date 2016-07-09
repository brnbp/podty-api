<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Transform\UserTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends ApiController
{
    private $userTransformer;

    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Get user data from specific username.
     *
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = UserRepository::getFirst($username);

        if ($user) {
            $user = $this->userTransformer->transform($user);
        }
        return $this->responseData($user);
    }

    public function create()
    {
        $validator = Validator::make(Input::all(), User::$rules);

        if ($validator->fails()) {
            return $this->respondErrorValidator($validator);
        }

        return $this->responseData(
            $this->userTransformer->transform(
                UserRepository::create(Input::all())
            )
        );
    }

    public function delete($username)
    {
        $user = UserRepository::getFirst($username);

        if (!$user) {
            return $this->responseData($user);
        }

        return $this->responseData(['removed' => $user->delete()]);
    }

    public function authenticate($username)
    {
        dd($username, Input::all());
    }

    private function responseData($data)
    {
        return empty($data) ? $this->respondNotFound() : $this->respondSuccess($data);
    }
}
