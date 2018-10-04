<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Response;
use Auth;

class AppController extends Controller
{
    
    public function __construct ()
    {}

    public function index ()
    {
        return view('index');
    }

    public function key ($key)
    {
        $key = sha1($key);

        $find = User::whereAccesskey($key)->first();

        if ($find == null || !$find->active)
            return Response::json(['status' => 400 ], 400 );

        if ($find->banned == 1)
            return Response::json(['status' => 401, 'banned' => true, 'banned_reason' => $find->banned_reason, 'banned_time' => $find->banned_time], 401);

        return Response::json(['status' => 200, 'id' => $find->id, 'name' => $find->first_name], 200);

    }

    public function code ($id, $code)
    {
        $user = User::whereId($id)->first();

        if ($user == null)
            return Response::json(['status' => 400, 'error' => 'User not found.'], 400 );

        $code = sha1($code);

        if ($user->accessPin == $code) {
            Auth::loginUsingId($id, true);
            return Response::json(['status' => 200, 'id' => $user->id, 'name' => $user->first_name], 200);
        } else {
            return Response::json(['status' => 401, 'error' => 'Incorrect PIN.'], 400 );
        }

    }

}
