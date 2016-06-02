<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Get user data from specific username.
     *
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        return DB::table('users')
            ->where('username', $username)
            ->get();
    }

    /**
     * Get all feeds from specific user
     * @param string $username
     */
    public function showFeed($username)
    {
        return DB::table('users')
            ->join('user_feeds', 'users.id', '=', 'user_feeds.user_id')
            ->join('feeds', 'user_feeds.feed_id', '=', 'feeds.id')
            ->where('users.username', $username)
            ->select('feeds.id', 'feeds.name', 'feeds.thumbnail_30')
            ->get();
    }
}
