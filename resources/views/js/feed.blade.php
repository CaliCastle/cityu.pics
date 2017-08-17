<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('js/anime.min.js') }}"></script>
<script>
    ;(function (window) {
        'use strict';

        var $currentPost,
            replyTo = false,
            originalUrl = window.location.href,
            originalTitle = document.title;

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

        // Initialize events.
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

            // Comment buttons binding.
            $('.feed-action__comment').on('click', function () {
                if (!$($postOverlay).hasClass('open')) {
                    $currentPost = $(this).parents('.feed-layout__panel')[0];
                    $postOverlay.classList.add('open');

                    expandPost();
                }
                focusCommentInput();
            });

            // More buttons binding.
            $('.feed-action__more').on('click', function () {
                this.parentNode.classList.add('open');
            });
            // Cancel more actions.
            $('.feed-more__cancel').on('click', function () {
                var $parent = $(this).parents('.feed-details__actions')[0],
                    $this = this;
                $this.parentNode.classList.add('flipOutY');
                setTimeout(function () {
                    $this.parentNode.classList.remove('flipOutY');
                    $parent.classList.remove('open');
                }, 650);
            });
            // Facebook sharing.
            $('.feed-more__facebook').on('click', function () {
                var $post = $(this).parents('.feed-layout__panel')[0];

                var newWindow = window.open(encodeURI('https://www.facebook.com/dialog/share?app_id=2005167386436657&href=' + '{{ url('/') }}/post/' + $post.getAttribute('post-id') + '&display=popup&ref=plugin&src=share_button'),
                'Facebook', 'height=500,width=600,toolbar=0,menubar=0,location=0');
                newWindow.focus();

                return false;
            });
            // Twitter sharing.
            $('.feed-more__twitter').on('click', function () {
                var $post = $(this).parents('.feed-layout__panel')[0];

                var newWindow = window.open(encodeURI('https://twitter.com/intent/tweet/?url=' + '{{ url('/') }}/post/' + $post.getAttribute('post-id') + '&tw_p=tweetbutton&original_referer={{ url('/') }}'),
                'Twitter', 'height=500,width=600,toolbar=0,menubar=0,location=0');
                newWindow.focus();

                return false;
            });

            // Delete buttons binding.
            $('.feed-more__delete').on('click', deletePost);

            // Load more button binding.
            $('.feed-loader button').on('click', function (e) {
                sendMorePostsRequest(e.target.parentNode);
            });

            var $body = document.body,
                $postOverlay = document.querySelector('.post-overlay');
            // Feed media zoom in event.
            $('.feed-layout__panel .feed-media').on('click', function (e) {
                $currentPost = e.target.parentNode.parentNode;
                $postOverlay.classList.add('open');

                expandPost();
            });
            // Close the expanded post.
            $('.post-overlay').on('click', function () {
                $currentPost.classList.add('closing');
                $currentPost.classList.remove('expanded');
                $currentPost.querySelector('.feed__comments').classList.add('block-loading');
                $currentPost.querySelector('.feed__comments').innerHTML = '';

                $('body').animate({scrollTop: $currentPost.style.top.split('px')[0]}, 400, 'swing');
                setTimeout(function () {
                    $postOverlay.classList.remove('open');
                    $currentPost.classList.remove('closing');
                }, 410);

                document.title = originalTitle;
                window.history.pushState({
                    "pageTitle": originalTitle
                }, document.title, originalUrl);
            });
        }

        // Front-end likes counter.
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

        // Likes a post.
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

        // Send load more request.
        function sendMorePostsRequest($button) {
            // Prevent from clicking again.
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

        // Zoom in post.
        function expandPost() {
            if (!$($currentPost).hasClass('expanded')) {
                // Scroll to the post.
                $('body').animate({scrollTop: $currentPost.style.top.split('px')[0]}, 400, 'swing');

                $currentPost.classList.add('expanded');
                // Display comment input.
                $($currentPost.querySelector('.feed-comment__input')).emojioneArea({
                    pickerPosition: "top",
                    tonesStyle: "bullet",
                    inline: true,
                    placeholder: "@lang('messages.posts.comments.placeholder')  ✍",
                    useSprite: true
                });

                // Bind comment button.
                $($currentPost.querySelector('.feed-comment__button')).on('click', submitComment);
                $($currentPost.querySelector('.emojionearea-editor')).keydown(function (e) {
                    if (e.keyCode == 13) {
                        submitComment();
                        return false;
                    }
                });

                // Load comments from server.
                loadComments();
                // Pushes url to browser history.
                pushPostToBrowserHistory();
            }
        }

        // Delete a post.
        function deletePost(e) {
            var $post = $(e.target).parents('.feed-layout__panel')[0],
                id = $post.getAttribute('post-id');

            togglePostModal(function () {
                $.ajax({
                    url: '/post/' + id,
                    method: 'DELETE',
                    data: {_token: Laravel.csrfToken},
                    success: function (s) {
                        if (s.status == 'success') {
                            // Bounce out animation.
                            $post.classList.add('animated');
                            $post.classList.add('bounceOut');
                            setTimeout(function () {
                                // Remove Node from HTML.
                                $post.remove();
                                // Re-layout the masonry.
                                masonry.layout();
                            }, 750);
                        }
                    },
                    error: function () {
                        displayErrorMessage();
                    }
                });
            }, $post);
        }

        // Toggle post modal.
        function togglePostModal(callback, $post) {
            if (!$post) {
                $post = $currentPost;
            }

            // Toggle feed modal state.
            $post.classList.add('feed-modal');
            // Close actions if opened.
            $post.querySelector('.feed-details__actions').classList.remove('open');
            // Cancel button binding.
            $post.querySelector('.feed-layout__modal .feed-modal__cancel').addEventListener('click', function () {
                // Bounce out animation.
                $post.querySelector('.feed-layout__modal').classList.add('bounceOut');
                setTimeout(function () {
                    $post.classList.remove('feed-modal');
                    $post.querySelector('.feed-layout__modal').classList.remove('bounceOut');
                }, 750);
            });
            // Confirm button binding.
            $post.querySelector('.feed-layout__modal .feed-modal__confirm').addEventListener('click', callback);
        }

        // Once clicks on the comment icon on each post.
        function focusCommentInput() {
            setTimeout(function () {
                $($currentPost.querySelector('.emojionearea-editor')).focus();
            }, 450);
        }

        var loadingComments = false;
        // TODO: add comments page

        // Loading comments thru ajax.
        function loadComments() {
            if (loadingComments)
                return false;

            loadingComments = true;

            var postId = $currentPost.getAttribute('post-id');

            $.get({
                url: '/load-comments/' + postId,
//                data: {}
                success: function (s) {
                    // Remove loading animation.
                    $currentPost.querySelector('.feed__comments.block-loading').classList.remove('block-loading');
                    // Add comments to node list.
                    $($currentPost.querySelector('.feed__comments')).append(s.html);
                    // Bind events for each comment.
                    commentsLoaded();
                },
                error: function () {
                    displayErrorMessage();
                },
                complete: function () {
                    loadingComments = false;
                }
            });
        }

        function commentsLoaded() {
            // Reply to comment.
            var $commentInput = $currentPost.querySelector('.feed-details__comment-input');
            $currentPost.querySelectorAll('.comment__reply-button').forEach(function (item) {
                $(item).on('click', function () {
                    var parent = $(item).parents(".comment-item")[0];
                    // Set whom to reply to.
                    replyTo = $(parent).attr('data-id');

                    $($commentInput).appendTo(parent.querySelector('.details'));
                    $currentPost.querySelector('.feed-details__comments').classList.add('replying');
                });
            });

            // Like to comment.
            $currentPost.querySelectorAll('.comment__like-button').forEach(function (item) {
                $(item).on('click', function () {
                    var parent = $(item).parents('.comment-item')[0];
                    // Send request to like the comment.
                    likeComment(parent.getAttribute('data-id'));

                    return false;
                });
            });

            // Cancel reply.
            $($currentPost.querySelector('.feed-comment__cancel-reply')).on('click', function () {
                resetCommentInput();
            });
        }

        // Likes the current comment
        function likeComment(id) {
            $.ajax({
                url: '/like-comment/' + id,
                method: 'PUT',
                data: {_token: Laravel.csrfToken},
                success: function (s) {
                    // Set number to new one.
                    var $comment = $('.comment-item[data-id=' + id + '] .details .actions .comment__like-button')[0];
                    $($comment).html(s.newLikes);
                    // Toggle liked class.
                    $($comment).toggleClass('liked');
                },
                error: function () {
                    displayErrorMessage();
                }
            });
        }

        var submittingComment = false;

        // Submit a comment
        function submitComment() {
            if (submittingComment)
                return false;

            var $commentButton = $currentPost.querySelector('.feed-comment__button'),
                content = $currentPost.querySelector('.emojionearea-editor').innerHTML.trim(),
                data = {
                    _token: Laravel.csrfToken,
                    content: content
                };

            content = content.replace(/&nbsp;/g, "").trim();
            // Empty string.
            if (content == '')
                return false;

            // Prevent from clicking again.
            $commentButton.classList.toggle('disabled');
            $commentButton.innerText = $commentButton.getAttribute('loading-text');

            // If we are replying to someone else.
            if (replyTo)
                data.parent = replyTo;

            // Set submitting to true.
            submittingComment = true;
            // Send ajax request.
            $.post({
                url: '/comment/' + $currentPost.getAttribute('post-id'),
                data: data,
                success: function (s) {
                    if ($currentPost.querySelector('.no-comments')) {
                        $currentPost.querySelector('.no-comments').remove();
                    }

                    if (replyTo) {
                        var selector = '.comment-item[data-id=' + replyTo + '] .comments-list';
                        $(s.html).prependTo($(selector)[0])
                    } else {
                        $(s.html).prependTo($currentPost.querySelector('ul.feed-comments__list'));
                    }

                    commentsLoaded();
                },
                error: function () {
                    displayErrorMessage();
                },
                complete: function () {
                    $commentButton.classList.toggle('disabled');
                    $commentButton.innerText = $commentButton.getAttribute('origin-text');
                    submittingComment = false;
                    resetCommentInput();
                }
            });
        }

        // Reset comment input.
        function resetCommentInput() {
            replyTo = '';

            // Put HTML node back to where it belongs.
            var $commentInput = $currentPost.querySelector('.feed-details__comment-input');
            $($commentInput).prependTo($currentPost.querySelector('.feed-details__comments'));

            // Remove replying class.
            if ($currentPost.querySelector('.replying'))
                $currentPost.querySelector('.replying').classList.remove('replying');
            // Clear the comment input.
            $currentPost.querySelector('.emojionearea-editor').innerHTML = '';
        }

        // Change url and push to history.
        function pushPostToBrowserHistory() {
            document.title = $currentPost.getAttribute('data-title');

            window.history.pushState({
                "pageTitle": document.title
            }, document.title, window.location.protocol + '//' + window.location.host + '/post/' + $currentPost.getAttribute('post-id'));
        }

        init();
    })(window);
</script>