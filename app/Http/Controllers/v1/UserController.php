<?php
namespace App\Http\Controllers\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Transform\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    private $userTransformer;

    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    public function show(User $username): JsonResponse
    {
        return $this->respondSuccess(
            $this->userTransformer->transform($username)
        );
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $user = UserRepository::create($request->all());

        return $this->respondSuccess($this->userTransformer->transform($user));
    }

    public function delete(User $username): JsonResponse
    {
        $deleted = UserRepository::delete($username);

        if (!$deleted) {
            return $this->respondBadRequest('excluding user with existing feeds');
        }

        return $this->respondSuccess(['removed' => true]);
    }

    public function find($term): JsonResponse
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

    public function touch(User $username): JsonResponse
    {
        $username->touch();

        return $this->respondSuccess();
    }

    public function authenticate(Request $request): JsonResponse
    {
        if (UserRepository::authenticate($request->get('username'), $request->get('password'))) {
            return $this->respondSuccess(['message' => 'user authenticated']);
        }

        return $this->respondUnauthorized('user not authenticated');
    }
}
