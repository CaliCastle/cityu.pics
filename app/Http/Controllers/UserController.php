<?php

namespace App\Http\Controllers;

use Image;
use Storage;
use App\User;
use App\Notification;
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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProfile(User $user)
    {
        $posts = $user->posts()->latest()->paginate(50);

        return view('profile', compact('user', 'posts'));
    }

    /**
     * Uploads a new avatar.
     *
     * @param Request $request
     *
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

        return asset('storage/users/avatars/' . $path);
    }

    /**
     * Follows a user.
     *
     * @param User    $user
     * @param Request $request
     *
     * @return array|bool
     */
    public function followUser(User $user, Request $request)
    {
        if ($user->id == $request->user()->id)
            return false;

        // Follow the user.
        $request->user()->follow($user);

        return [
            'state'     => $request->user()->followed($user) ? ($request->user()->followedEachOther($user) ? 'both' : 'followed') : 'unfollowed',
            'followers' => $user->followers
        ];
    }

    /**
     * Reads notifications endpoint.
     *
     * @return array
     */
    public function readNotifications(Request $request)
    {
        if (str_contains($request->input('id'), ',')) {
            // Multiple read request.
            foreach (explode(',', $request->input('id')) as $id) {
                $this->readNotification($id);
            }
        } else {
            // Single read request
            $this->readNotification(intval($request->input('id')));
        }

        return [
            'status' => 'success'
        ];
    }

    /**
     * Gets inbox notifications json.
     *
     * @param Request $request
     *
     * @return array
     */
    public function getInbox(Request $request)
    {
        return [
            'status' => 'success',
            'inbox'  => $request->user()->inboxNotifications()
        ];
    }

    /**
     * Shows settings of the user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSettings()
    {
        return view('settings');
    }

    public function showSearch(Request $request)
    {
        // TODO: Search implementation
        return $request->input('q');
    }

    /**
     * Read a notification.
     *
     * @param $id
     *
     * @return mixed
     */
    protected function readNotification($id)
    {
        $notification = Notification::findOrFail($id);

        return $notification->read();
    }
}
