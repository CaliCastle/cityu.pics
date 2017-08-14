<ul class="feed-comments__list">
@forelse($comments as $comment)
    @include('discussion.comment')
@empty
    <li class="no-comments text-center">
        <h5>@lang('messages.posts.comments.no-comments')</h5>
    </li>
@endforelse
</ul>