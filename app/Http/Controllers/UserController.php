<?php
namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = UserRepository::first($username);

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
        
        $user = UserRepository::create(Input::all());
    
        Mail::queue('emails.welcome', ['user' => $user->username], function ($m) use($user) {
            $m->from('signin@podty.co', 'Podty');
            $m->to($user->email, $user->username)->subject('Welcome to Podty');
        });

        return $this->responseData(
            $this->userTransformer->transform($user)
        );
    }

    public function delete($username)
    {
        $user = UserRepository::first($username);

        if (!$user) {
            return $this->responseData($user);
        }

        $deleted = UserRepository::delete($user);

        if (!$deleted) {
            return $this->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->respondError('excluding user with existing feeds');
        }

        return $this->responseData(['removed' => true]);
    }

    public function authenticate()
    {
        $validator = Validator::make(Input::all(), [
            'username' => 'bail|required|alpha_num|min:3|max:20',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->respondErrorValidator($validator);
        }

        if (UserRepository::verifyAuthentication(Input::all())) {
            return $this->respondSuccess(['message' => 'user authenticated']);
        }

        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)
            ->respondError('user not authenticated');
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
            'total_matches' => $users->count()
        ]);
    }

    public function touch($username)
    {
        $user = UserRepository::first($username);
        
        if (!$user) {
            return $this->respondNotFound();
        }
        $user->touch();

        return response('', 200);
    }

    private function responseData($data)
    {
        return empty($data) ? $this->respondNotFound() : $this->respondSuccess($data);
    }
}
