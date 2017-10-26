<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Mail\UserRegistered;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Transform\UserTransformer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $username)
    {
        return $this->responseData(
            $this->userTransformer->transform($username)
        );
    }

    public function create()
    {
        $validator = Validator::make(Input::all(), User::$rules);

        if ($validator->fails()) {
            return $this->respondErrorValidator($validator);
        }

        $user = UserRepository::create(Input::all());

        Mail::send(new UserRegistered($user));

        return $this->responseData(
            $this->userTransformer->transform($user)
        );
    }

    public function delete(User $username)
    {
        $deleted = UserRepository::delete($username);

        if (!$deleted) {
            return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->respondError('excluding user with existing feeds');
        }

        return $this->responseData(['removed' => true]);
    }

    public function find($term)
    {
        $users = User::where('username', 'LIKE', "%$term%")
            ->select('id', 'username', 'friends_count', 'podcasts_count')
            ->get();

        if (!$users->count()) {
            return $this->respondNotFound();
        }

        return $this->respondSuccess($users->toArray(), [
            'total_matches' => $users->count(),
        ]);
    }

    public function touch(User $username)
    {
        $username->touch();

        return $this->respondSuccess();
    }

    private function responseData($data)
    {
        return empty($data) ? $this->respondNotFound() : $this->respondSuccess($data);
    }
}
