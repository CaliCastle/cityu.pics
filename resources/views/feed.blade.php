@extends('layouts.app')

@section('title', 'Feed')

@section('content')
    <div class="feed-content">
        <div class="container">
            <div class="feed-layout">
                @for($i = 1; $i < 35; $i++)
                <div class="feed-layout__panel">
                    <div class="feed-layout__panel-content">
                        <img src="/images/p{{ $n = rand(1, 11) }}.{{ $n == 5 ? 'png' : 'jpg' }}" alt="Picture">
                        <div class="feed-details">
                            <!-- Tags -->
                            <div class="feed-details__header">
                                <ul class="feed-details__tags">
                                    <li>
                                        <a href="#" class="feed-tag">legit</a>
                                    </li>
                                    <li>
                                        <a href="#" class="feed-tag">awesome</a>
                                    </li>
                                    <li>
                                        <a href="#" class="feed-tag">lit</a>
                                    </li>
                                    <li>
                                        <a href="#" class="feed-tag">onfire</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Content -->
                            <div class="feed-details__content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi, aperiam consectetur maiores maxime placeat repellendus vel.</p>
                            </div>
                            <!-- Avatar and actions -->
                            <div class="feed-details__footer">
                                <a href="#" class="feed-details__user">
                                    <div class="avatar">
                                        <img src="/avatar.png" alt="Avatar" class="img-circle">
                                    </div>
                                    <div class="name verified">
                                        <span>Cali Castle</span>
                                    </div>
                                </a>
                                <div class="feed-details__actions">
                                    <a class="feed-action__like" href="#">
                                        <span class="feed-like__count">{{ random_int(5, 999) }}</span>
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
                @endfor
            </div>
        </div>
    </div>
@endsection
