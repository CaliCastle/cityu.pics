<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the feed page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFeed()
    {
        return view('feed');
    }

    /**
     * Confirm the user from email link.
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmUser($token)
    {
        $user = User::where('remember_token', $token)->first();

        if ($user !== null || !$user->confirmed) {
            $user->confirmed();
            return redirect('feed')->with('status', [
                'message' => 'Your account has been confirmed!'
            ]);
        } else {
            return redirect('feed')->with('status', [
                'type'    => 'error',
                'message' => 'The account cannot be confirmed.'
            ]);
        }
    }
}
