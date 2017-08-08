@extends('layouts.app')

@section('title', 'Feed')

@section('content')
    <div class="feed-content">
        <div class="container">
            <div class="feed-layout">
                @foreach($posts as $post)
                <div class="feed-layout__panel">
                    <div class="feed-layout__panel-content">
                        @foreach($post->allMedia() as $media)
                        <img src="{{ $media }}" alt="Picture">
                        @endforeach
                        <div class="feed-details">
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
                            <!-- Content -->
                            <div class="feed-details__content">
                                <p>{!! $post->caption !!}</p>
                            </div>
                            <!-- Avatar and actions -->
                            <div class="feed-details__footer">
                                <a href="#" class="feed-details__user">
                                    <div class="avatar">
                                        <img src="/avatar.png" alt="Avatar" class="img-circle">
                                    </div>
                                    <div class="name">
                                    {{--<div class="name verified">--}}
                                        <span>{{ $post->user->name }}</span>
                                    </div>
                                </a>
                                <div class="feed-details__actions">
                                    <a class="feed-action__like" href="#">
                                        <span class="feed-like__count">{{ $post->likes }}</span>
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                    <a class="feed-action__comment" href="#">
                                        <i class="fa fa-comment-o"></i>
                                    </a>
                                    <a class="feed-action__more" href="#">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
