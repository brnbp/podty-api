<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Transform\UserTransformer;
use Illuminate\Http\Response;

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
     * @param \App\Models\User $username
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $username)
    {
        return $this->respondSuccess(
            $this->userTransformer->transform($username)
        );
    }

    public function create(CreateUserRequest $request)
    {
        $user = UserRepository::create($request->all());

        return $this->respondSuccess($this->userTransformer->transform($user));
    }

    public function delete(User $username)
    {
        $deleted = UserRepository::delete($username);

        if (!$deleted) {
            return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->respondError('excluding user with existing feeds');
        }

        return $this->respondSuccess(['removed' => true]);
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
}
