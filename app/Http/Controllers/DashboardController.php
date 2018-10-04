<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Auth;
use Route;

class DashboardController extends Controller
{

    public function __construct ()
    {
        $this->middleware('auth');
    }

    public static function routes ()
    {
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('logout', function () {
                if (!Auth::guest()) {
                    Auth::logout();
                    return Response::json(['status' => 200 ], 200 );
                } else {
                    return Response::json(['status' => 400, 'error' => 'User not logged in.' ], 400 );
                }
            });
        });
    }

    public function index ()
    {
        return view('dashboard.index');
    }
}
