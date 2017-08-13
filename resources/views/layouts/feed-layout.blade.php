<div class="feed-layout loading">
    <div class="feed-sizer"></div>
    @include('layouts.feed-panel')
</div>
@if($posts->hasMorePages())
    <div class="feed-loader">
        <button>@lang('messages.posts.load-more')</button>
    </div>
@endif