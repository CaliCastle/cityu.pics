<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Storage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\AccountRegistered;

class HomeController extends Controller
{
    /**
     * Storage root directory path for uploaded files.
     *
     * @var string
     */
    protected $uploadStorageRoot = 'public/users/';

    /**
     * Url for uploaded files.
     *
     * @var string
     */
    protected $storageUrl = 'users/';

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
     * Resend confirmation code.
     *
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

    /**
     * Handler for uploading images.
     *
     * @param Request $request
     * @return array
     */
    public function uploadImages(Request $request)
    {
        if (!$request->file('file')->isValid())
            return response('Error', 403);

        $fileName = str_random(40) . '.' . $request->file('file')->extension();
        $request->file('file')->storeAs($this->uploadStorageRoot . Carbon::now()->format('FY'), $fileName);

        return [
            'path' => Storage::url($this->storageUrl . Carbon::now()->format('FY') . '/' . $fileName)
        ];
    }
}
