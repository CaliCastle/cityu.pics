@foreach($posts as $post)
    <div class="feed-layout__panel" post-id="{{ $post->id }}" data-title="{{ str_limit(strip_tags($post->caption), 30) }}">
        <div class="feed-layout__panel-content">
            <div class="feed-media">
                @foreach($post->allMedia() as $media)
                    <img src="{{ $media }}" alt="Picture">
                @endforeach
            </div>
            <div class="feed-details">
            @if($post->hasTags())
                    <div class="feed-details__header">
                        <ul class="feed-details__tags">
                            @foreach($post->tags as $tag)
                                <li>
                                    <a href="{{ $tag->link() }}" class="feed-tag">{{ $tag->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
            @endif
                <div class="feed-details__content">
                    <p>{!! $post->caption !!}</p>
                </div>
                <div class="feed-details__footer">
                    <a href="{{ ($postAuthor = $post->user)->profileLink() }}" class="feed-details__user">
                        <div class="avatar">
                            <img @if(Auth::id() == $postAuthor->id):src="User.avatarUrl" @else src="{{ $postAuthor->avatarUrl }}"@endif alt="{{ $postAuthor->name }}" class="img-circle">
                        </div>
                        <div class="name{{ $postAuthor->isAdmin() ? ' admin' : ($postAuthor->isVerified() ? ' verified' : '') }}">
                            <span v-cloak>@if(Auth::id() == $postAuthor->id)@{{ User.name }}@else{{ $postAuthor->name }}@endif</span>
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
                        <a class="feed-action__comment waves-effect" href="javascript:void(0)">
                            <i class="fa fa-comment-o"></i>
                        </a>
                        <a class="feed-action__more waves-effect" href="javascript:void(0)">
                            <i class="fa fa-ellipsis-h"></i>
                        </a>
                        <div class="feed-more__list animated flipInY">
                            <div class="feed-more__item feed-more__facebook waves-effect">
                                <i class="fa fa-facebook"></i>
                                <span>Facebook</span>
                            </div>
                            <div class="feed-more__item feed-more__twitter waves-effect">
                                <i class="fa fa-twitter"></i>
                                <span>Twitter</span>
                            </div>
                            @if(Auth::id() == $postAuthor->id)
                                <div class="feed-more__item feed-more__delete waves-effect">
                                    <i class="fa fa-trash"></i>
                                    <span>@lang('messages.posts.actions.delete')</span>
                                </div>
                            @endif
                            <div class="feed-more__item feed-more__cancel waves-effect">
                                <i class="fa fa-times"></i>
                                <span>@lang('messages.composer.cancel')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feed-details__date">
                    <time title="{{ $post->created_at }}" class="timeago" datetime="{{ $post->created_at->toIso8601String() }}">{{ $post->created_at->diffForHumans() }}</time>
                </div>
                <div class="feed-details__expandable">
                    <div class="feed-details__comments">
                        <div class="feed-details__comment-input animated fadeInUp">
                            <div class="feed-comment__input" contenteditable></div>
                            <button class="feed-comment__cancel-reply"><i class="fa fa-times"></i>&nbsp;@lang('messages.posts.comments.cancel')</button>
                            <button class="feed-comment__button waves-effect waves-light" loading-text="@lang('messages.posts.comments.posting')" origin-text="@lang('messages.posts.comments.post')">@lang('messages.posts.comments.post')</button>
                        </div>

                        <div class="feed__comments block-loading"></div>

                    </div>
                </div>
            </div>
        </div>
        <div class="feed-layout__modal animated bounceIn">
            <button class="feed-modal__button feed-modal__cancel waves-effect">@lang('messages.composer.cancel')</button>
            <button class="feed-modal__button feed-modal__confirm waves-effect waves-light animated infinite pulse">@lang('messages.posts.actions.confirm')!</button>
        </div>
    </div>
@endforeach