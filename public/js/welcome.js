( function( window ) {

    'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

    function classReg( className ) {
        return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
    }

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
    var hasClass, addClass, removeClass;

    if ( 'classList' in document.documentElement ) {
        hasClass = function( elem, c ) {
            return elem.classList.contains( c );
        };
        addClass = function( elem, c ) {
            elem.classList.add( c );
        };
        removeClass = function( elem, c ) {
            elem.classList.remove( c );
        };
    }
    else {
        hasClass = function( elem, c ) {
            return classReg( c ).test( elem.className );
        };
        addClass = function( elem, c ) {
            if ( !hasClass( elem, c ) ) {
                elem.className = elem.className + ' ' + c;
            }
        };
        removeClass = function( elem, c ) {
            elem.className = elem.className.replace( classReg( c ), ' ' );
        };
    }

    function toggleClass( elem, c ) {
        var fn = hasClass( elem, c ) ? removeClass : addClass;
        fn( elem, c );
    }

    var classie = {
        // full names
        hasClass: hasClass,
        addClass: addClass,
        removeClass: removeClass,
        toggleClass: toggleClass,
        // short names
        has: hasClass,
        add: addClass,
        remove: removeClass,
        toggle: toggleClass
    };

// transport
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( classie );
    } else if ( typeof exports === 'object' ) {
        // CommonJS
        module.exports = classie;
    } else {
        // browser global
        window.classie = classie;
    }

})( window );

;(function(window) {

    'use strict';

    // helper functions

    /**
     * enable/disable page scrolling. from http://stackoverflow.com/a/4770179
     */
        // left: 37, up: 38, right: 39, down: 40,
        // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
    var keys = {37: 1, 38: 1, 39: 1, 40: 1};

    function preventDefault(e) {
        e = e || window.event;
        if (e.preventDefault)
            e.preventDefault();
        e.returnValue = false;
    }

    function preventDefaultForScrollKeys(e) {
        if (keys[e.keyCode]) {
            preventDefault(e);
            return false;
        }
    }

    function disableScroll() {
        if (window.addEventListener) // older FF
            window.addEventListener('DOMMouseScroll', preventDefault, false);
        window.onwheel = preventDefault; // modern standard
        window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
        window.ontouchmove  = preventDefault; // mobile
        document.onkeydown  = preventDefaultForScrollKeys;
    }

    function enableScroll() {
        if (window.removeEventListener)
            window.removeEventListener('DOMMouseScroll', preventDefault, false);
        window.onmousewheel = document.onmousewheel = null;
        window.onwheel = null;
        window.ontouchmove = null;
        document.onkeydown = null;
    }

    /**
     * from https://davidwalsh.name/javascript-debounce-function
     */
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    /**
     * from http://stackoverflow.com/a/7228322
     */
    function randomIntFromInterval(min,max) {
        return Math.floor(Math.random()*(max-min+1)+min);
    }

    // main page container
    var mainContainer = document.querySelector('body'),
        // the grid element
        gridEl = mainContainer.querySelector('.grid'),
        // grid items
        gridItems = [].slice.call(gridEl.querySelectorAll('.grid__item')),
        // Logo element
        logoEl = mainContainer.querySelector('.title-wrap > img'),
        // main title element
        titleEl = mainContainer.querySelector('.title-wrap > .title--main'),
        // main subtitle element
        subtitleEl = mainContainer.querySelector('.title-wrap > .title--sub'),
        // the fullscreen element/division that will slide up, giving the illusion the items will fall down
        pagemover = mainContainer.querySelector('.page--mover'),
        // the loading element shown while the images are loaded
        loadingStatusEl = pagemover.querySelector('.la-square-jelly-box'),
        // window sizes (width and height)
        winsize = {width: window.innerWidth, height: window.innerHeight},
        // translation values (x and y): percentages of the item´s width and height; scale value; rotation (z) value
        // these are the values that the 6 initial images will have
        introPositions = [
            {tx: -.6, ty:-.3, s:1.1, r:-20},
            {tx: .2, ty:-.7, s:1.4, r:1},
            {tx: .5, ty:-.5, s:1.3, r:15},
            {tx: -.2, ty:-.4, s:1.4, r:-17},
            {tx: -.15, ty:-.4, s:1.2, r:-5},
            {tx: .7, ty:-.2, s:1.1, r:15}
        ],
        // the phone
        deviceEl = mainContainer.querySelector('.device'),
        // the animated button that triggers the effect when clicked
        showGridCtrl = document.getElementById('showgrid'),
        // the title and subtitle shown on top of the grid
        pageTitleEl = mainContainer.querySelector('.page__title > .page__title-main'),
        pageSubTitleEl = mainContainer.querySelector('.page__title > .page__title-sub'),
        // the grid´s load more button
        loadMoreCtrl = mainContainer.querySelector('button.button--load'),
        // true if the animation is currently running
        isAnimating,
        // true if the user scrolls (rather than clicking the down arrow)
        scrolled,
        // current view: stack | grid
        view = 'stack';

    function init() {
        // appending a unique string to every image src as a workaround for an apparent Chrome issue with the imagesLoaded (cache is not cleared, premature firing seems to happen)
        [].slice.call(gridEl.querySelectorAll('img')).forEach(function(el) { el.src += '?' + Number(new Date()); });

        // disable scroll while loading images
        classie.add(document.body, 'overflow');
        disableScroll();
        // preload images
        imagesLoaded(gridEl, function() {
            // enable page scroll again
            enableScroll();
            // controls the visibility of the grid items. Adding this class will make them visible.
            classie.add(mainContainer, 'view--loaded');
            // show initial view
            showIntro();
            // bind events
            initEvents();
        });

        // enable dropdown menus
        [].slice.call(document.querySelectorAll('.dropdown-toggle')).forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                classie.toggle(el.parentNode, 'open');
            });
        });
    }

    /**
     * shows the initial stack with the 6 images behind the phone
     */
    function showIntro() {
        // display the first set of 6 grid items behind the phone
        gridItems.slice(0,6).forEach(function(item, pos) {
            // first we position all the 6 items on the bottom of the page (item´s center is positioned on the middle of the page bottom)
            // then we move them up and to the sides (extra values) and also apply a scale and rotation
            var itemOffset = item.getBoundingClientRect(),
                settings = introPositions[pos],
                center = {
                    x : winsize.width/2 - (itemOffset.left + item.offsetWidth/2),
                    y : winsize.height - (itemOffset.top + item.offsetHeight/2)
                }

            // first position the items behind the phone
            dynamics.css(item, {
                opacity: 1,
                translateX: center.x,
                translateY: center.y,
                scale: 0.5
            });

            // now animate each item to its final position
            dynamics.animate(item, {
                translateX: center.x + settings.tx*item.offsetWidth,
                translateY: center.y + settings.ty*item.offsetWidth,
                scale : settings.s,
                rotateZ: settings.r
            }, {
                type: dynamics.spring,
                duration: 2000,
                frequency: 400,
                friction: 550,
                delay: pos * 100
            });
        });

        // also animate/slide the device in:
        // first, push it slightly down (to make it complete out of the viewport we´d need to set the translateY to winsize.height * 0.45 --> 45vh)
        dynamics.css(deviceEl, { translateY: winsize.height * 0.25 } );
        // now animate it up
        dynamics.animate(deviceEl, { translateY: 0 }, {
            type: dynamics.bezier,
            points: [{"x":0,"y":0,"cp":[{"x":0.2,"y":1}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
            duration: 1000
        });
    }

    /**
     * bind/initialize the events
     */
    function initEvents() {
        // show the grid when the showGridCtrl is clicked
        showGridCtrl.addEventListener('click', showGrid);

        // show the grid when the user scrolls the page
        var scrollfn = function() {
            scrolled = true;
            showGrid();
            window.removeEventListener('scroll', scrollfn);
        };
        window.addEventListener('scroll', scrollfn);

        // window resize: recalculate window sizes and reposition the 6 grid items behind the phone (if the grid view is not yet shown)
        window.addEventListener('resize', debounce(function(ev) {
            // reset window sizes
            winsize = {width: window.innerWidth, height: window.innerHeight};

            if( view === 'stack' ) {
                gridItems.slice(0,6).forEach(function(item, pos) {
                    // first reset all items
                    dynamics.css(item, { scale: 1, translateX: 0, translateY: 0, rotateZ: 0 });

                    // now, recalculate..
                    var itemOffset = item.getBoundingClientRect(),
                        settings = introPositions[pos];

                    dynamics.css(item, {
                        translateX: winsize.width/2 - (itemOffset.left + item.offsetWidth/2) + settings.tx*item.offsetWidth,
                        translateY: winsize.height - (itemOffset.top + item.offsetHeight/2) + settings.ty*item.offsetWidth,
                        scale : settings.s,
                        rotateZ: settings.r
                    });
                });
            }
        }, 10));
    }

    /**
     * shows the grid
     */
    function showGrid() {
        // return if currently animating
        if( isAnimating ) return;
        isAnimating = true;

        // hide the showGrid ctrl
        dynamics.css(showGridCtrl, {display: 'none'});

        // main title animation
        dynamics.animate(titleEl, { translateY: -winsize.height/2, opacity: 0 }, {
            type: dynamics.bezier,
            points: [{"x":0,"y":0,"cp":[{"x":0.7,"y":0}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
            duration: 600
        });

        // main subtitle animation
        dynamics.animate(subtitleEl, { translateY: -winsize.height/2, opacity: 0 }, {
            type: dynamics.bezier,
            points: [{"x":0,"y":0,"cp":[{"x":0.7,"y":0}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
            duration: 600,
            delay: 100
        });

        // device animation
        dynamics.animate(deviceEl, { translateY: 500, opacity: 0 }, {
            type: dynamics.bezier,
            points: [{"x":0,"y":0,"cp":[{"x":0.7,"y":0}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
            duration: 600
        });

        // pagemover animation
        dynamics.animate(pagemover, { translateY: -winsize.height}, {
            type: dynamics.bezier,
            points: [{"x":0,"y":0,"cp":[{"x":0.7,"y":0}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
            duration: 600,
            delay: scrolled ? 0 : 120,
            complete: function(el) {
                // hide the pagemover
                dynamics.css(el, { opacity: 0 });
                // view is now ´grid´
                view = 'grid';
                classie.add(mainContainer, 'view--grid');
            }
        });

        // items animation
        gridItems.slice(0,6).forEach(function(item, pos) {
            dynamics.stop(item);
            dynamics.animate(item, { scale: 1, translateX: 0, translateY: 0, rotateZ: 0 }, {
                type: dynamics.spring,
                duration: scrolled ? 2400 : 2400,
                frequency: 400,
                friction: 400,
                delay: scrolled ? 0 : pos * 30 + 100
            });
        });

        // page title animation
        dynamics.css(pageTitleEl, { translateY: 200, opacity: 0 });
        dynamics.animate(pageTitleEl, { translateY: 0, opacity: 1 }, {
            type: dynamics.bezier,
            points: [{"x":0,"y":0,"cp":[{"x":0.2,"y":1}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
            duration: 800,
            delay: 400
        });

        // page subtitle animation
        dynamics.css(pageSubTitleEl, { translateY: 150, opacity: 0 });
        dynamics.animate(pageSubTitleEl, { translateY: 0, opacity: 1 }, {
            type: dynamics.bezier,
            points: [{"x":0,"y":0,"cp":[{"x":0.2,"y":1}]},{"x":1,"y":1,"cp":[{"x":0.3,"y":1}]}],
            duration: 800,
            delay: 500
        });

        // the remaining grid items
        gridItems.slice(6).forEach(function(item) {
            dynamics.css(item, { scale: 0, opacity: 0 });
            dynamics.animate(item, { scale: 1, opacity: 1 }, {
                type: dynamics.spring,
                duration: 2000,
                frequency: 400,
                friction: 400,
                delay: randomIntFromInterval(100,400)
            });
        });
    }

    // force the scrolling to the top of the page (from http://stackoverflow.com/a/23312671)
    window.onbeforeunload = function(){
        window.scrollTo(0,0);
    }

    init();

})(window);

;(function(window) {

    'use strict';

    // Helper vars and functions.
    function extend(a, b) {
        for(var key in b) {
            if( b.hasOwnProperty( key ) ) {
                a[key] = b[key];
            }
        }
        return a;
    }

    function createDOMEl(type, className, content) {
        var el = document.createElement(type);
        el.className = className || '';
        el.innerHTML = content || '';
        return el;
    }

    /**
     * RevealFx obj.
     */
    function RevealFx(el, options) {
        this.el = el;
        this.options = extend({}, this.options);
        extend(this.options, options);
        this._init();
    }

    /**
     * RevealFx options.
     */
    RevealFx.prototype.options = {
        // If true, then the content will be hidden until it´s "revealed".
        isContentHidden: true,
        // The animation/reveal settings. This can be set initially or passed when calling the reveal method.
        revealSettings: {
            // Animation direction: left right (lr) || right left (rl) || top bottom (tb) || bottom top (bt).
            direction: 'lr',
            // Revealer´s background color.
            bgcolor: '#f0f0f0',
            // Animation speed. This is the speed to "cover" and also "uncover" the element (seperately, not the total time).
            duration: 500,
            // Animation easing. This is the easing to "cover" and also "uncover" the element.
            easing: 'easeInOutQuint',
            // percentage-based value representing how much of the area should be left covered.
            coverArea: 0,
            // Callback for when the revealer is covering the element (halfway through of the whole animation).
            onCover: function(contentEl, revealerEl) { return false; },
            // Callback for when the animation starts (animation start).
            onStart: function(contentEl, revealerEl) { return false; },
            // Callback for when the revealer has completed uncovering (animation end).
            onComplete: function(contentEl, revealerEl) { return false; }
        }
    };

    /**
     * Init.
     */
    RevealFx.prototype._init = function() {
        this._layout();
    };

    /**
     * Build the necessary structure.
     */
    RevealFx.prototype._layout = function() {
        var position = getComputedStyle(this.el).position;
        if( position !== 'fixed' && position !== 'absolute' && position !== 'relative' ) {
            this.el.style.position = 'relative';
        }
        // Content element.
        this.content = createDOMEl('div', 'block-revealer__content', this.el.innerHTML);
        if( this.options.isContentHidden) {
            this.content.style.opacity = 0;
        }
        // Revealer element (the one that animates)
        this.revealer = createDOMEl('div', 'block-revealer__element');
        this.el.classList.add('block-revealer');
        this.el.innerHTML = '';
        this.el.appendChild(this.content);
        this.el.appendChild(this.revealer);
    };

    /**
     * Gets the revealer element´s transform and transform origin.
     */
    RevealFx.prototype._getTransformSettings = function(direction) {
        var val, origin, origin_2;

        switch (direction) {
            case 'lr' :
                val = 'scale3d(0,1,1)';
                origin = '0 50%';
                origin_2 = '100% 50%';
                break;
            case 'rl' :
                val = 'scale3d(0,1,1)';
                origin = '100% 50%';
                origin_2 = '0 50%';
                break;
            case 'tb' :
                val = 'scale3d(1,0,1)';
                origin = '50% 0';
                origin_2 = '50% 100%';
                break;
            case 'bt' :
                val = 'scale3d(1,0,1)';
                origin = '50% 100%';
                origin_2 = '50% 0';
                break;
            default :
                val = 'scale3d(0,1,1)';
                origin = '0 50%';
                origin_2 = '100% 50%';
                break;
        };

        return {
            // transform value.
            val: val,
            // initial and halfway/final transform origin.
            origin: {initial: origin, halfway: origin_2},
        };
    };

    /**
     * Reveal animation. If revealSettings is passed, then it will overwrite the options.revealSettings.
     */
    RevealFx.prototype.reveal = function(revealSettings) {
        // Do nothing if currently animating.
        if( this.isAnimating ) {
            return false;
        }
        this.isAnimating = true;

        // Set the revealer element´s transform and transform origin.
        var defaults = { // In case revealSettings is incomplete, its properties default to:
                duration: 500,
                easing: 'easeInOutQuint',
                delay: 0,
                bgcolor: '#f0f0f0',
                direction: 'lr',
                coverArea: 0
            },
            revealSettings = revealSettings || this.options.revealSettings,
            direction = revealSettings.direction || defaults.direction,
            transformSettings = this._getTransformSettings(direction);

        this.revealer.style.WebkitTransform = this.revealer.style.transform =  transformSettings.val;
        this.revealer.style.WebkitTransformOrigin = this.revealer.style.transformOrigin =  transformSettings.origin.initial;

        // Set the Revealer´s background color.
        this.revealer.style.backgroundColor = revealSettings.bgcolor || defaults.bgcolor;

        // Show it. By default the revealer element has opacity = 0 (CSS).
        this.revealer.style.opacity = 1;

        // Animate it.
        var self = this,
            // Second animation step.
            animationSettings_2 = {
                complete: function() {
                    self.isAnimating = false;
                    if( typeof revealSettings.onComplete === 'function' ) {
                        revealSettings.onComplete(self.content, self.revealer);
                    }
                }
            },
            // First animation step.
            animationSettings = {
                delay: revealSettings.delay || defaults.delay,
                complete: function() {
                    self.revealer.style.WebkitTransformOrigin = self.revealer.style.transformOrigin = transformSettings.origin.halfway;
                    if( typeof revealSettings.onCover === 'function' ) {
                        revealSettings.onCover(self.content, self.revealer);
                    }
                    anime(animationSettings_2);
                }
            };

        animationSettings.targets = animationSettings_2.targets = this.revealer;
        animationSettings.duration = animationSettings_2.duration = revealSettings.duration || defaults.duration;
        animationSettings.easing = animationSettings_2.easing = revealSettings.easing || defaults.easing;

        var coverArea = revealSettings.coverArea || defaults.coverArea;
        if( direction === 'lr' || direction === 'rl' ) {
            animationSettings.scaleX = [0,1];
            animationSettings_2.scaleX = [1,coverArea/100];
        }
        else {
            animationSettings.scaleY = [0,1];
            animationSettings_2.scaleY = [1,coverArea/100];
        }

        if( typeof revealSettings.onStart === 'function' ) {
            revealSettings.onStart(self.content, self.revealer);
        }
        anime(animationSettings);
    };

    window.RevealFx = RevealFx;

})(window);

// Scroll to reveal.
(function () {
    var shareScrollWatch = document.getElementById('share-image'),
        shareWatcher = scrollMonitor.create(shareScrollWatch, -300),
        shareImage = new RevealFx(shareScrollWatch, {
            revealSettings: {
                bgcolor: '#4b84ec',
                direction: 'rl',
                easing: 'easeInOutQuad',
                delay: 150,
                onStart: function(contentEl, revealerEl) {
                    anime.remove(contentEl.parentNode);
                },
                onCover: function(contentEl, revealerEl) {
                    contentEl.parentNode.style.opacity = 1;
                    anime({
                        targets: contentEl.parentNode,
                        duration: 600,
                        delay: 80,
                        easing: 'easeOutExpo',
                        scale: [0.5,1],
                        opacity: [0,1]
                    });
                }
            }
        }),
        shareTitle1 = new RevealFx(document.querySelector('#share-title1'), {
            revealSettings: {
                bgcolor: '#fcf652',
                direction: 'tb',
                delay: 750,
                onCover: function (contentEl) {
                    contentEl.style.opacity = 1;
                }
            }
        }),
        shareTitle2 = new RevealFx(document.querySelector('#share-title2'), {
            revealSettings: {
                bgcolor: '#d0d0d0',
                direction: 'bt',
                delay: 1050,
                onCover: function (contentEl) {
                    contentEl.style.opacity = 1;
                }
            }
        });
    var commentScrollWatch = document.getElementById('comment-image'),
        commentWatcher = scrollMonitor.create(commentScrollWatch, -150),
        commentImage = new RevealFx(commentScrollWatch, {
            revealSettings: {
                bgcolor: '#4b84ec',
                direction: 'rl',
                easing: 'easeInOutQuad',
                delay: 150,
                onStart: function(contentEl, revealerEl) {
                    anime.remove(contentEl);
                },
                onCover: function(contentEl, revealerEl) {
                    contentEl.parentNode.style.opacity = 1;
                    anime({
                        targets: contentEl.parentNode,
                        duration: 500,
                        delay: 80,
                        easing: 'easeOutExpo',
                        scale: [0.5,1],
                        opacity: [0,1]
                    });
                }
            }
        }),
        commentTitle1 = new RevealFx(document.querySelector('#comment-title1'), {
            revealSettings: {
                bgcolor: '#6371c6',
                direction: 'rl',
                delay: 750,
                onCover: function (contentEl) {
                    contentEl.style.opacity = 1;
                }
            }
        }),
        commentTitle2 = new RevealFx(document.querySelector('#comment-title2'), {
            revealSettings: {
                bgcolor: '#bf5649',
                direction: 'lr',
                delay: 1140,
                onCover: function (contentEl) {
                    contentEl.style.opacity = 1;
                }
            }
        });
    var inboxScrollWatch = document.getElementById('inbox-image'),
        inboxWatcher = scrollMonitor.create(inboxScrollWatch, -300),
        inboxImage = new RevealFx(inboxScrollWatch, {
            revealSettings: {
                bgcolor: '#c93431',
                direction: 'rl',
                easing: 'easeInOutQuad',
                delay: 150,
                onStart: function(contentEl, revealerEl) {
                    anime.remove(contentEl);
                },
                onCover: function(contentEl, revealerEl) {
                    contentEl.parentNode.style.opacity = 1;
                    anime({
                        targets: contentEl.parentNode,
                        duration: 500,
                        delay: 80,
                        easing: 'easeOutExpo',
                        scale: [0.5,1],
                        opacity: [0,1]
                    });
                }
            }
        }),
        inboxTitle1 = new RevealFx(document.querySelector('#inbox-title1'), {
            revealSettings: {
                bgcolor: '#80c6a5',
                direction: 'lr',
                delay: 750,
                onCover: function (contentEl) {
                    contentEl.style.opacity = 1;
                }
            }
        }),
        inboxTitle2 = new RevealFx(document.querySelector('#inbox-title2'), {
            revealSettings: {
                bgcolor: '#f0ee1a',
                direction: 'rl',
                delay: 1140,
                onCover: function (contentEl) {
                    contentEl.style.opacity = 1;
                }
            }
        });
    var checkinScrollWatch = document.getElementById('checkin-image'),
        checkinWatcher = scrollMonitor.create(checkinScrollWatch, -300),
        checkinImage = new RevealFx(checkinScrollWatch, {
            revealSettings: {
                bgcolor: '#c93431',
                direction: 'rl',
                easing: 'easeInOutQuad',
                delay: 150,
                onStart: function(contentEl, revealerEl) {
                    anime.remove(contentEl);
                },
                onCover: function(contentEl, revealerEl) {
                    contentEl.parentNode.style.opacity = 1;
                    anime({
                        targets: contentEl.parentNode,
                        duration: 500,
                        delay: 80,
                        easing: 'easeOutExpo',
                        scale: [0.5,1],
                        opacity: [0,1]
                    });
                }
            }
        }),
        checkinTitle1 = new RevealFx(document.querySelector('#checkin-title1'), {
            revealSettings: {
                bgcolor: '#dfeaec',
                direction: 'bt',
                delay: 550,
                onCover: function (contentEl) {
                    contentEl.style.opacity = 1;
                }
            }
        }),
        checkinTitle2 = new RevealFx(document.querySelector('#checkin-title2'), {
            revealSettings: {
                bgcolor: '#70e249',
                direction: 'tb',
                delay: 880,
                onCover: function (contentEl) {
                    contentEl.style.opacity = 1;
                }
            }
        });
    var languagesScrollWatch = document.getElementById('languages'),
        languagesWatcher = scrollMonitor.create(languagesScrollWatch, -400),
        languagesTitle1 = languagesScrollWatch.querySelector('#languages-title1'),
        languagesTitle2 = languagesScrollWatch.querySelector('#languages-title2');

    shareWatcher.enterViewport(function () {
        shareImage.reveal();
        shareTitle1.reveal();
        shareTitle2.reveal();
        shareWatcher.destroy();
    });
    commentWatcher.enterViewport(function () {
        commentImage.reveal();
        commentTitle1.reveal();
        commentTitle2.reveal();
        commentWatcher.destroy();
    });
    inboxWatcher.enterViewport(function () {
        inboxImage.reveal();
        inboxTitle1.reveal();
        inboxTitle2.reveal();
        inboxWatcher.destroy();
    });
    checkinWatcher.enterViewport(function () {
        checkinImage.reveal();
        checkinTitle1.reveal();
        checkinTitle2.reveal();
        checkinWatcher.destroy();
    });
    languagesWatcher.enterViewport(function () {
        languagesTitle1.style.display = 'block';
        languagesTitle2.style.display = 'block';
    });
})();