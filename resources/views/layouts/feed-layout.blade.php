<div class="feed-layout loading">
    <div class="feed-sizer"></div>
    @include('layouts.feed-panel')
</div>
@if(method_exists($posts, 'hasMorePages') && $posts->hasMorePages())
    <div class="feed-loader">
        <button>@lang('messages.posts.load-more')</button>
    </div>
@endif