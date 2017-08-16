<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Storage;
use App\Tag;
use App\Post;
use App\User;
use App\Comment;
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
    protected $postUploadStorageRoot = 'public/posts/';

    /**
     * Url for uploaded files.
     *
     * @var string
     */
    protected $storageUrl = 'posts/';

    /**
     * Posts per page.
     *
     * @var int
     */
    protected $postsPerPage = 50;

    /**
     * Creates a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'confirmUser']);
        $this->middleware('confirmed', ['except' => ['confirmUser', 'showLocked', 'unlock', 'resendCode']]);
    }

    /**
     * Shows the application dashboard.
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
     * Confirms the user from email link.
     *
     * @param $token
     * @param $email
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmUser($token, $email)
    {
        $user = User::where('confirm_token', $token)->first();

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
     * Shows locked page.
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
     * Unlocks a user.
     *
     * @param Request $request
     *
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
     * Resends confirmation code.
     *
     * @param Request $request
     *
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
     *
     * @return array
     */
    public function uploadImages(Request $request)
    {
        $this->validate($request, [
            'file' => 'image|max:5000'
        ]);

        if (!$request->file('file')->isValid())
            return response('Error', 403);

        $fileName = str_random(40) . '.' . $request->file('file')->extension();
        $request->file('file')->storeAs($this->postUploadStorageRoot . Carbon::now()->format('FY'), $fileName);

        return [
            'path' => Storage::url($this->storageUrl . Carbon::now()->format('FY') . '/' . $fileName)
        ];
    }

    /**
     * Posts a new post.
     *
     * @param Request $request
     *
     * @return array
     */
    public function postNew(Request $request)
    {
        $post = Post::createFromComposer($request->all());

        $request->user()->posts()->save($post);

        // Generates associated tags.
        if ($request->has('tags') && $request->input('tags') != '')
            Tag::generate($request->input('tags'), $post);

        return [
            'status' => 'success'
        ];
    }

    /**
     * Loads more posts by page.
     *
     * @param $page
     *
     * @return array
     */
    public function loadMorePosts($page)
    {
        $posts = Post::latest()->skip(($page - 1) * $this->postsPerPage)->take($this->postsPerPage)->get();

        if (!$posts->count())
            return ['hasMore' => 'false'];

        return [
            'hasMore' => 'true',
            'posts'   => view('layouts.feed-panel', compact('posts'))->render()
        ];
    }

    /**
     * Likes a post.
     *
     * @param Post    $post
     * @param Request $request
     *
     * @return array
     */
    public function likePost(Post $post, Request $request)
    {
        $request->user()->likePost($post);

        return [
            'status' => 'success'
        ];
    }

    /**
     * Likes a comment.
     *
     * @param Comment $comment
     * @param Request $request
     *
     * @return array
     */
    public function likeComment(Comment $comment, Request $request)
    {
        $request->user()->likeComment($comment);

        return [
            'status'   => 'success',
            'newLikes' => $comment->getLikes()
        ];
    }

    /**
     * Comments a post.
     *
     * @param Post    $post
     * @param Request $request
     *
     * @return array
     */
    public function commentPost(Post $post, Request $request)
    {
        $comment = $request->user()->commentPost($post, $request->input('content'), $request->input('parent'));

        // Render comment HTML for inserting
        return [
            'status' => 'success',
            'html'   => view('discussion.comment', compact('comment'))->render()
        ];
    }

    /**
     * Loads comments of a post.
     *
     * @param Post $post
     *
     * @return array
     */
    public function loadComments(Post $post)
    {
        // Load hot comments first.
        $comments = $post->superComments()->orderBy('like_count', 'desc')->latest()->paginate(20);

        return [
            'html' => view('discussion.comments', compact('comments'))->render()
        ];
    }

    /**
     * Deletes a post.
     *
     * @param Post    $post
     * @param Request $request
     *
     * @return array|bool
     */
    public function deletePost(Post $post, Request $request)
    {
        if ($post->user->id != $request->user()->id)
            return false;

        $post->delete();

        return [
            'status' => 'success'
        ];
    }
}
