@extends('layouts.app')

@section('title', str_limit(strip_tags($post->caption), 25))

@section('og:image', url($post->allMedia()[0]))

@section('content')
    <div class="feed-content">
        <div class="container feed-layout" style="column-count: 1">
            <div class="feed-layout__panel expanded" post-id="{{ $post->id }}" data-title="{{ str_limit(strip_tags($post->caption), 25) }}" style="position:relative">
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
                                            <a href="#" class="feed-tag">{{ $tag->name }}</a>
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
                                    <img src="{{ Voyager::image($postAuthor->avatar) }}" alt="{{ $postAuthor->name }}" class="img-circle">
                                </div>
                                <div class="name{{ $postAuthor->isAdmin() ? ' admin' : ($postAuthor->isVerified() ? ' verified' : '') }}">
                                    <span>{{ $postAuthor->name }}</span>
                                </div>
                            </a>
                            <div class="feed-details__actions">
                                <span>@lang('messages.posts.actions.sign-in')</span>
                            </div>
                        </div>
                        <div class="feed-details__date">
                            <span title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop