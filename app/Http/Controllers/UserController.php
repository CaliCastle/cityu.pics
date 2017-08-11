<?php

namespace App\Http\Controllers;

use Image;
use Session;
use Storage;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Avatar storage path.
     *
     * @var string
     */
    protected $avatarStoragePath = 'public/users/avatars/';

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

    /**
     * Uploads a new avatar.
     *
     * @param Request $request
     * @return string
     */
    public function uploadAvatar(Request $request)
    {
        $file = $request->file('image');
        $size = round($request->width);
        $resize = $request->width >= 800;
        $path = str_random(100) . '.' . $file->clientExtension();

        // Crop and resize avatar if necessary.
        $image = Image::make($file->getPathname())
            ->crop($size, $size, round($request->input('x')), round($request->input('y')));
        if ($resize)
            $image->resize(800, 800);

        Storage::put($this->avatarStoragePath . $path, $image->encode());

        // Save it to the database.
        $request->user()->changeAvatar($path);

        // Flash message
        Session::flash('status', ['message' => trans('messages.profile.upload-avatar.success')]);

        return asset('storage/users/avatars/' . $path);
    }
}
