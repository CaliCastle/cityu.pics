<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Mail\AccountRegistered;

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
        $this->middleware('confirmed', ['except' => ['confirmUser', 'showLocked', 'unlock', 'resendCode']]);
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
     * @param $email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmUser($token, $email)
    {
        $user = User::where('remember_token', $token)->first();

        if ($user && !$user->hasConfirmed() && $user->email == $email) {
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

    /**
     * Show locked page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showLocked()
    {
        if (Auth::user() && Auth::user()->hasConfirmed())
            return redirect()->intended();

        return view('locked');
    }

    /**
     * Unlock a user.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function unlock(Request $request)
    {
        $code = $request->input('code');
        if ($request->user()->validateConfirmation($code))
            return redirect('feed')->with('status', [
                'message' => 'Your account has been confirmed!'
            ]);

        return redirect('locked')->withErrors(validator($request->all(), [
            'code' => 'required|digits:5|in:incorrect'
        ]));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function resendCode(Request $request)
    {
        $request->user()->resetConfirmationCode();
        Mail::to($request->user())->sendNow(new AccountRegistered($request->user()));

        return [
            'sent' => 1
        ];
    }
}
