<div class="feed-layout loading">
    <div class="feed-sizer"></div>
    @include('layouts.feed-panel')
</div>
@if(method_exists($posts, 'links'))
    <div class="feed-loader">
        {{ $posts->links() }}
    </div>
@endif