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
}
