<li>
    <div class="comment-item" data-id="{{ $comment->id }}">
        <div class="avatar{{ ($commentUser = $comment->user)->isAdmin() ? ' admin' : ($commentUser->isVerified() ? ' verified' : '') }}">
            <a href="{{ $commentUser->profileLink() }}">
                <img src="{{ Voyager::image($commentUser->avatar) }}" alt="{{ $commentUser->name }}" class="img-circle">
            </a>
        </div>
        <div class="details">
            <div class="meta">
                <strong><a href="{{ $commentUser->profileLink() }}">{{ $commentUser->name }}</a></strong>
            </div>
            <div class="body">
                <p>{!! $comment->content !!}</p>
            </div>
            <div class="actions">
                <span class="time">{{ $comment->created_at->diffForHumans() }}</span>
                <ul class="action-list">
                    <li><a href="javascript:;" id="like-button" title="" class="{{ auth()->user()->likedComment($comment) ? "liked" : "" }}">{{ $comment->likes->count() }}</a></li>
                    <li><a href="javascript:;" id="reply-button" title=""><i class="fa fa-btn fa-reply"></i></a></li>
                    <li class="liked-users animated bounceIn"></li>
                </ul>
            </div>
        </div>
        @if($comment->children)
            @unless(isset($no_children))
                <ul class="comments-list">
                    @each('discussion.comment', $comment->children, 'comment')
                </ul>
            @endunless
        @endif
    </div>
</li>