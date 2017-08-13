<ul class="feed-comments__list">
@foreach($comments as $comment)
    @include('discussion.comment')
@endforeach
</ul>