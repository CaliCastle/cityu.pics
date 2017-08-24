<?php

namespace App\Http\Controllers;

use Image;
use App\Tag;
use Storage;
use App\User;
use App\Post;
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
     * Http request.
     *
     * @var Request
     */
    protected $request;

    /**
     * UserController constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
     * @return string
     */
    public function uploadAvatar()
    {
        $file = $this->request->file('image');
        $size = round($this->request->width);
        $resize = $this->request->width >= 800;
        $path = str_random(100) . '.' . $file->clientExtension();

        // Crop and resize avatar if necessary.
        $image = Image::make($file->getPathname())
            ->crop($size, $size, round($this->request->input('x')), round($this->request->input('y')));
        if ($resize)
            $image->resize(800, 800);

        Storage::put($this->avatarStoragePath . $path, $image->encode());

        // Save it to the database.
        $this->request->user()->changeAvatar($path);

        return asset('storage/users/avatars/' . $path);
    }

    /**
     * Follows a user.
     *
     * @param User $user
     *
     * @return array|bool
     */
    public function followUser(User $user)
    {
        if ($user->id == $this->request->user()->id)
            return false;

        // Follow the user.
        $this->request->user()->follow($user);

        return [
            'state'     => $this->request->user()->followed($user) ? ($this->request->user()->followedEachOther($user) ? 'both' : 'followed') : 'unfollowed',
            'followers' => $user->followers
        ];
    }

    /**
     * Reads notifications endpoint.
     *
     * @return array
     */
    public function readNotifications()
    {
        if (str_contains($this->request->input('id'), ',')) {
            // Multiple read request.
            foreach (explode(',', $this->request->input('id')) as $id) {
                $this->readNotification($id);
            }
        } else {
            // Single read request
            $this->readNotification(intval($this->request->input('id')));
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
    public function getInbox()
    {
        return [
            'status' => 'success',
            'inbox'  => $this->request->user()->inboxNotifications()
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

    /**
     * Saves personal settings.
     *
     * @return array
     */
    public function savePersonalSettings()
    {
        $this->validate($this->request, $this->getSettingsRule());

        $this->request->user()->changeSettings($this->request->all());

        return $this->successResponse(trans('messages.settings.changed'));
    }

    /**
     * Saves privacy settings.
     *
     * @return array
     */
    public function savePrivacySettings()
    {
        $this->request->user()->changePrivacy($this->request->all());

        return $this->successResponse(trans('messages.settings.changed'));
    }

    /**
     * Saves feed settings.
     *
     * @return array
     */
    public function saveFeedSettings()
    {
        $this->request->user()->changeFeedSettings($this->request->all());

        return $this->successResponse(trans('messages.settings.changed'));
    }

    /**
     * Gets settings validation rules.
     *
     * @return array
     */
    protected function getSettingsRule()
    {
        $attributes = [
            'name'        => 'required|max:255|unique:users,name,' . $this->request->user()->id,
            'description' => 'max:120|nullable|string'
        ];

        if ($this->request->has('password') && trim($this->request->input('password')) != '')
            $attributes = array_merge($attributes, [
                'password' => 'required|min:6|confirmed'
            ]);

        return $attributes;
    }

    /**
     * Shows search results.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSearch()
    {
        $query = $this->request->input('q');

        // Get related users.
        $users = User::search($query);
        // Get related tags.
        $tags = Tag::search($query);
        // Get related posts.
        $posts = Post::search($query);

        return view('search', compact('query', 'users', 'tags', 'posts'));
    }

    /**
     * Checks in daily.
     *
     * @return array
     */
    public function checkIn()
    {
        $this->request->user()->checkIn();

        return $this->successResponse();
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
