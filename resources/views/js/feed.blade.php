<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('js/anime.min.js') }}"></script>
<script>
    ;(function (window) {
        'use strict';

        var $currentPost,
            replyTo = false;

        /**
         * GridLoaderFx obj.
         */
        function GridLoaderFx(el, options) {
            this.el = el;
            this.items = this.el.querySelectorAll('.feed-layout__panel:not(.generated)');
        }

        GridLoaderFx.prototype.effects = {
            'fade': {
                // Sort target elements function.
                sortTargetsFn: function(a,b) {
                    var aBounds = a.getBoundingClientRect(),
                        bBounds = b.getBoundingClientRect();

                    return (aBounds.left - bBounds.left) || (aBounds.top - bBounds.top);
                },
                animeOpts: {
                    duration: function(t,i) {
                        return 500 + i*50;
                    },
                    easing: 'easeOutExpo',
                    delay: function(t,i) {
                        return i * 20;
                    },
                    opacity: {
                        value: [0,1],
                        duration: function(t,i) {
                            return 250 + i * 50;
                        },
                        easing: 'linear'
                    },
                    translateY: [400,0]
                }
            },
            'scale': {
                animeOpts: {
                    duration: function(t,i) {
                        return 600 + i*75;
                    },
                    easing: 'easeOutExpo',
                    delay: function(t,i) {
                        return i*50;
                    },
                    opacity: {
                        value: [0,1],
                        easing: 'linear'
                    },
                    scale: [0,1]
                }
            },
        }

        GridLoaderFx.prototype._render = function(effect) {
            // Reset styles.
            this._resetStyles();

            var self = this,
                effectSettings = this.effects[effect],
                animeOpts = effectSettings.animeOpts

            if( effectSettings.perspective != undefined ) {
                [].slice.call(this.items).forEach(function(item) {
                    item.parentNode.style.WebkitPerspective = item.parentNode.style.perspective = effectSettings.perspective + 'px';
                });
            }

            if( effectSettings.origin != undefined ) {
                [].slice.call(this.items).forEach(function(item) {
                    item.style.WebkitTransformOrigin = item.style.transformOrigin = effectSettings.origin;
                });
            }

            if( effectSettings.itemOverflowHidden ) {
                [].slice.call(this.items).forEach(function(item) {
                    item.parentNode.style.overflow = 'hidden';
                });
            }

            animeOpts.targets = effectSettings.sortTargetsFn && typeof effectSettings.sortTargetsFn === 'function' ? [].slice.call(this.items).sort(effectSettings.sortTargetsFn) : this.items;
            anime.remove(animeOpts.targets);
            anime(animeOpts);

            this.el.classList.remove('loading');

            this.items.forEach(function (item) {
                item.classList.add('generated');
            });
        };

        GridLoaderFx.prototype._resetStyles = function() {
            this.el.style.WebkitPerspective = this.el.style.perspective = 'none';
            [].slice.call(this.items).forEach(function(item) {
                var gItem = item.parentNode;
                item.style.opacity = 0;
                item.style.WebkitTransformOrigin = item.style.transformOrigin = '50% 50%';
                item.style.transform = 'none';

                gItem.style.overflow = '';
            });
        };

        window.GridLoaderFx = GridLoaderFx;

        var body = document.querySelector('.feed-content'),
            feedGrid = document.querySelector('.feed-layout'),
            masonry, gridLoader, currentPage = 1, pageLoaded = false;

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
            // Preload images
            imagesLoaded(feedGrid, function () {
                // Initialize Masonry layout
                masonry = new Masonry(feedGrid, {
                    itemSelector: '.feed-layout__panel',
                    columnWidth: '.feed-sizer',
                    percentPosition: true,
                    transitionDuration: 0
                });
                // Init GridLoaderFx.
                gridLoader = new GridLoaderFx(feedGrid);
                feedGrid.classList.remove('grid--loading');

                if (pageLoaded) {
                    gridLoader._render('scale');
                } else {
                    setTimeout(function () {
                        gridLoader._render('scale');
                    }, 850);
                    pageLoaded = true;
                }
            });
            // Remove loading class from #app
            body.classList.remove('loading');

            // Like buttons animation
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

            // Load more button bind.
            $('.feed-loader button').on('click', function (e) {
                sendMorePostsRequest(e.target.parentNode);
            });

            var $body = document.body,
                $postOverlay = document.querySelector('.post-overlay');

            // Feed media zoom in event.
            $('.feed-layout__panel .feed-media').on('click', function (e) {
                $currentPost = e.target.parentNode.parentNode;
                $currentPost.classList.add('expanded');
                $postOverlay.classList.add('open');

                expandPost();
            });
            $('.post-overlay').on('click', function () {
                $currentPost.classList.add('closing');
                $currentPost.classList.remove('expanded');

                $('body').animate({scrollTop: $currentPost.style.top.split('px')[0]}, 400, 'swing');
                setTimeout(function () {
                    $postOverlay.classList.remove('open');
                    $currentPost.classList.remove('closing');
                }, 410);
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
                        displayErrorMessage();
                },
                error: function () {
                    displayErrorMessage();
                }
            });
        }

        function sendMorePostsRequest($button) {
            $button.classList.add('requesting');

            $.post({
                url: '/posts/' + (currentPage + 1),
                data: {_token: Laravel.csrfToken},
                success: function (s) {
                    currentPage++;

                    if (s.hasMore == 'true') {
                        $(feedGrid).append(s.posts);
                        $button.classList.remove('requesting');

                        init();
                    } else {
                        $button.remove();
                    }
                },
                error: function () {
                    displayErrorMessage();
                }
            });
        }

        function expandPost() {
            // Display comment input
            $($currentPost.querySelector('.feed-details__expandable .feed-comment__input')).emojioneArea({
                pickerPosition: "top",
                tonesStyle: "bullet",
                inline: true,
                placeholder: "@lang('messages.posts.comments.placeholder')  ✍",
                useSprite: true
            });

            // Bind comment button
            $($currentPost.querySelector('.feed-comment__button')).on('click', submitComment);
            $($currentPost.querySelector('.feed-details__expandable .emojionearea-editor')).keydown(function (e) {
                if (e.keyCode == 13) {
                    submitComment();
                    return false;
                }
            });
        }

        function submitComment() {
            var $commentButton = $currentPost.querySelector('.feed-comment__button'),
                data = {
                    _token: Laravel.csrfToken,
                    content: $currentPost.querySelector('.emojionearea-editor').innerHTML
                };
            $commentButton.classList.toggle('disabled');

            if (replyTo)
                data.parent = replyTo;

            $.post({
                url: '/comment/' + $currentPost.getAttribute('post-id'),
                data: data,
                success: function (s) {
                    console.log(s);
                },
                error: function () {
                    displayErrorMessage();
                },
                complete: function () {
                    $commentButton.classList.toggle('disabled');
                }
            });
        }

        init();
    })(window);
</script>