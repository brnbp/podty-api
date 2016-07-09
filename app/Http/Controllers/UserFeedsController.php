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
class UserFeedsController extends ApiController
{
    /**
     * Get all feeds from specific user
     * @param string $username
     */
    public function show($username)
    {
        $data = DB::table('users')
            ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
            ->join('feeds', 'user_feeds.feed_id', '=', 'feeds.id')
            ->where('users.username', $username)
            ->select('feeds.id', 'feeds.name', 'feeds.thumbnail_30')
            ->get();

        return $this->responseData($data);
    }
    
    private function responseData($data)
    {
        return empty($data) ? $this->respondNotFound() : $this->respondSuccess($data);
    }
}
