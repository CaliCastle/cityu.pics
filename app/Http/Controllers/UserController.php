<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('confirmed');
    }

    /**
     * Shows the user's profile.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile(User $user)
    {
        $posts = $user->posts()->latest()->simplePaginate(30);

        return view('profile', compact('user', 'posts'));
    }
}
