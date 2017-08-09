@extends('layouts.app')

@section('title', 'Feed')

@section('content')
    <div class="feed-content">
        <div class="container">
            <div class="feed-layout">
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
                                <a href="#" class="feed-details__user">
                                    <div class="avatar">
                                        <img src="{{ Voyager::image(($user = $post->user)->avatar) }}" alt="{{ $user->name }}" class="img-circle">
                                    </div>
                                    <div class="name">
                                    {{--<div class="name verified">--}}
                                        <span>{{ $user->name }}</span>
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
        </div>
    </div>
@endsection

@push('scripts')
<script>
    ;(function (window) {
        'use strict';

        // taken from mo.js demos
        function isIOSSafari() {
            var userAgent;
            userAgent = window.navigator.userAgent;
            return userAgent.match(/iPad/i) || userAgent.match(/iPhone/i);
        };

        // taken from mo.js demos
        function isTouch() {
            var isIETouch;
            isIETouch = navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
            return [].indexOf.call(window, 'ontouchstart') >= 0 || isIETouch;
        };

        // taken from mo.js demos
        var isIOS = isIOSSafari(),
            clickHandler = isIOS || isTouch() ? 'touchstart' : 'click';

        function extend( a, b ) {
            for( var key in b ) {
                if( b.hasOwnProperty( key ) ) {
                    a[key] = b[key];
                }
            }
            return a;
        }

        function Animocon(el, options) {
            this.el = el;
            this.options = extend( {}, this.options );
            extend( this.options, options );

            this.checked = $(el).hasClass('liked');

            this.timeline = new mojs.Timeline();

            for(var i = 0, len = this.options.tweens.length; i < len; ++i) {
                this.timeline.add(this.options.tweens[i]);
            }

            var self = this;
            this.el.addEventListener(clickHandler, function() {
                if( self.checked ) {
                    self.options.onUnCheck();
                }
                else {
                    self.options.onCheck();
                    self.timeline.start();
                }
                self.checked = !self.checked;
                sendLikePostRequest($(el).parents('.feed-layout__panel')[0].getAttribute('post-id'));
            });
        }

        Animocon.prototype.options = {
            tweens : [
                new mojs.Burst({
                    shape : 'circle',
                    isRunLess: true
                })
            ],
            onCheck : function() { return false; },
            onUnCheck : function() { return false; }
        };

        function init() {
            $('button.feed-action__like').each(function () {
                var item = this;
                var icon = item.querySelector('span.fa'),
                    like_counter = item.querySelector('span.feed-like__count');

                new Animocon(item, {
                    tweens: [
                        // ring animation
                        new mojs.Transit({
                            parent: item,
                            duration: 750,
                            type: 'circle',
                            radius: {0: 40},
                            fill: 'transparent',
                            stroke: '#f34e44',
                            strokeWidth: {35: 0},
                            opacity: 0.85,
                            x: '58%',
                            y: '50%',
                            isRunLess: true,
                            easing: mojs.easing.bezier(0, 1, 0.5, 1)
                        }),
                        new mojs.Transit({
                            parent: item,
                            duration: 500,
                            delay: 100,
                            type: 'circle',
                            radius: {0: 20},
                            fill: 'transparent',
                            stroke: '#4598f3',
                            strokeWidth: {15: 0},
                            opacity: 0.54,
                            x: '36%',
                            y: '50%',
                            shiftX: 40,
                            shiftY: -45,
                            isRunLess: true,
                            easing: mojs.easing.sin.out
                        }),
                        new mojs.Transit({
                            parent: item,
                            duration: 500,
                            delay: 180,
                            type: 'circle',
                            radius: {0: 10},
                            fill: 'transparent',
                            stroke: '#43c022',
                            strokeWidth: {10: 0},
                            opacity: 0.8,
                            x: '50%',
                            y: '50%',
                            shiftX: -10,
                            shiftY: -60,
                            isRunLess: true,
                            easing: mojs.easing.sin.out
                        }),
                        new mojs.Transit({
                            parent: item,
                            duration: 800,
                            delay: 240,
                            type: 'circle',
                            radius: {0: 20},
                            fill: 'transparent',
                            stroke: '#dd55c7',
                            strokeWidth: {5: 0},
                            opacity: 0.9,
                            x: '46%',
                            y: '55%',
                            shiftX: -70,
                            shiftY: -10,
                            isRunLess: true,
                            easing: mojs.easing.sin.out
                        }),
                        new mojs.Transit({
                            parent: item,
                            duration: 800,
                            delay: 240,
                            type: 'circle',
                            radius: {0: 20},
                            fill: 'transparent',
                            stroke: '#e5cc25',
                            strokeWidth: {5: 0},
                            opacity: 0.6,
                            x: '50%',
                            y: '50%',
                            shiftX: 80,
                            shiftY: -20,
                            isRunLess: true,
                            easing: mojs.easing.sin.out
                        }),
                        new mojs.Transit({
                            parent: item,
                            duration: 1000,
                            delay: 300,
                            type: 'circle',
                            radius: {0: 15},
                            fill: 'transparent',
                            stroke: '#e14b7c',
                            strokeWidth: {5: 0},
                            opacity: 0.5,
                            x: '50%',
                            y: '50%',
                            shiftX: 20,
                            shiftY: -60,
                            isRunLess: true,
                            easing: mojs.easing.sin.out
                        }),
                        new mojs.Transit({
                            parent: item,
                            duration: 600,
                            delay: 330,
                            type: 'circle',
                            radius: {0: 25},
                            fill: 'transparent',
                            stroke: '#32505f',
                            strokeWidth: {5: 0},
                            opacity: 0.46,
                            x: '50%',
                            y: '50%',
                            shiftX: -20,
                            shiftY: -40,
                            isRunLess: true,
                            easing: mojs.easing.sin.out
                        }),
                        // icon scale animation
                        new mojs.Tween({
                            duration: 1200,
                            easing: mojs.easing.ease.out,
                            onUpdate: function (progress) {
                                if (progress > 0.3) {
                                    var elasticOutProgress = mojs.easing.elastic.out(1.43 * progress - 0.43);
                                    icon.style.WebkitTransform = icon.style.transform = 'scale3d(' + elasticOutProgress + ',' + elasticOutProgress + ',1)';
                                }
                                else {
                                    icon.style.WebkitTransform = icon.style.transform = 'scale3d(0,0,1)';
                                }
                            }
                        })
                    ],
                    onCheck: function () {
                        addOrRemoveLikeCounter(item, like_counter, icon);
                    },
                    onUnCheck: function () {
                        addOrRemoveLikeCounter(item, like_counter, icon);
                    }
                });
            });
        }

        function addOrRemoveLikeCounter(item, like_counter, icon) {
            if ($(item).hasClass('liked')) {
                $(item).removeClass('liked');
                $(icon).removeClass('fa-heart').addClass('fa-heart-o');

                if (Number.isInteger(Number(like_counter.innerHTML)))
                    like_counter.innerHTML = Number(like_counter.innerHTML) - 1;
            } else {
                $(item).addClass('liked');
                $(icon).removeClass('fa-heart-o').addClass('fa-heart');

                if (Number.isInteger(Number(like_counter.innerHTML)))
                    like_counter.innerHTML = Number(like_counter.innerHTML) + 1;
            }
        }

        function sendLikePostRequest(id) {
            $.ajax({
                url: '/like-post/' + Number(id),
                data: {_token: Laravel.csrfToken},
                method: 'PUT',
                success: function (status) {
                    if (status.status != 'success')
                        toastr.error('Something went wrong, try again.');
                },
                error: function () {
                    toastr.error('Something went wrong, try again.');
                }
            });
        }

        init();
    })(window);
</script>
@endpush