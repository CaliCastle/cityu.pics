<div class="feed-layout loading">
    <div class="feed-sizer"></div>
    @foreach($posts as $post)
        <div class="feed-layout__panel" post-id="{{ $post->id }}">
            <div class="feed-layout__panel-content">
                @foreach($post->allMedia() as $media)
                    <img src="{{ $media }}" alt="Picture">
                @endforeach
                <div class="feed-details">
                @if($post->hasTags())
                    <!-- Tags -->
                        <div class="feed-details__header">
                            <ul class="feed-details__tags">
                                @foreach($post->tags as $tag)
                                    <li>
                                        <a href="#" class="feed-tag">{{ $tag->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                @endif
                <!-- Content -->
                    <div class="feed-details__content">
                        <p>{!! $post->caption !!}</p>
                    </div>
                    <!-- Avatar and actions -->
                    <div class="feed-details__footer">
                        <a href="{{ ($postAuthor = $post->user)->profileLink() }}" class="feed-details__user">
                            <div class="avatar">
                                <img src="{{ Voyager::image($postAuthor->avatar) }}" alt="{{ $postAuthor->name }}" class="img-circle">
                            </div>
                            <div class="name{{ $postAuthor->isAdmin() ? ' admin' : ($postAuthor->isVerified() ? ' verified' : '') }}">
                                <span>{{ $postAuthor->name }}</span>
                            </div>
                        </a>
                        <div class="feed-details__actions">
                            <button class="feed-action__like{{ ($liked = Auth::user()->likedPost($post)) ? ' liked' : '' }}">
                                <span class="feed-like__count">{{ $post->likes }}</span>
                                @if($liked)
                                    <span class="fa fa-heart"></span>
                                @else
                                    <span class="fa fa-heart-o"></span>
                                @endif
                            </button>
                            <a class="feed-action__comment" href="#">
                                <i class="fa fa-comment-o"></i>
                            </a>
                            <a class="feed-action__more" href="#">
                                <i class="fa fa-ellipsis-h"></i>
                            </a>
                        </div>
                    </div>
                    <div class="feed-details__date">
                        <span title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>