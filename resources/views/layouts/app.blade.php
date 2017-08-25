@include('layouts.header')
<body>

<div class="post-overlay"></div>
<div class="full-overlay"></div>

<main id="app">

@include('layouts.partials.navbar')

@yield('content')
<!-- Footer section -->
	@include('layouts.footer')

</main>

<div class="Search">
	<button id="btn-search-close" class="btn--search-close" aria-label="Close search form"><i class="fa fa-times"></i>
	</button>
	<form class="Search__form" action="{{ url('search') }}">
		<input class="Search__input browser-default" type="search" name="q"
		       placeholder="@lang('messages.navbar.search.placeholder')" autocomplete="off" autocorrect="off"
		       autocapitalize="off" spellcheck="false"/>
		<span class="Search__info">@lang('messages.navbar.search.tips')</span>
	</form>
</div>

@if(Auth::check())
	<div class="composer">
		<div class="composer-box animated bounceIn">
			<div class="composer-user-section">
				<img class="img-circle" src="{{ Auth::user()->avatarUrl }}" alt="{{ Auth::user()->name }}">
				<b>{{ Auth::user()->name }}:</b>
				<a href="#" class="close-button">
					<i class="fa fa-close"></i>
				</a>
			</div>
			<div class="composer-images-section">
				<form class="dropzone" id="composer-dropzone" action="{{ route('upload') }}" method="POST"
				      enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="dz-message">
						<i class="composer-images"></i>
						<span>@lang('messages.composer.description-title')...</span>
						<br>
						<span>@lang('messages.composer.description-tips', ['size' => 5, 'count' => 6])</span>
					</div>
					<div class="fallback">
						<input type="file" name="file" multiple>
					</div>
				</form>
			</div>
			<div class="composer-comment-section">
				<div class="composer-comment-area" id="composer-comment-area"></div>
			</div>
			<div class="composer-tags-section">
				<div id="composer-tags-input"></div>
			</div>
			<div class="composer-actions">
				<a class="composer-cancel" href="#">@lang('messages.composer.cancel')</a>
				<a class="composer-post disabled" href="javascript:void(0)">@lang('messages.composer.post')</a>
			</div>
		</div>
	</div>
@endif

<div class="flying-buttons">
	<a class="flying-button compose-new animated bounce" href="javascript:void(0)">
		<span class="fa fa-plus"></span>
	</a>
	<a class="flying-button tooltipped animated bounceIn hidden" href="javascript:void(0)" id="back-to-top"
	   data-tooltip="@lang('messages.footer.back-to-top')" data-position="left" data-delay="50">
		<span class="fa fa-chevron-up"></span>
	</a>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/materialize.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/emojionearea.min.js') }}"></script>
<script src="{{ asset('js/taggle.js') }}"></script>
<script src="{{ voyager_asset('lib/js/toastr.min.js') }}"></script>
<script>
    function displayErrorMessage() {
        toastr.error('@lang('messages.alerts.error').');
    }

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

    function extend(a, b) {
        for (var key in b) {
            if (b.hasOwnProperty(key)) {
                a[key] = b[key];
            }
        }
        return a;
    }

    function Animocon(el, options) {
        this.el = el;
        this.options = extend({}, this.options);
        extend(this.options, options);

        this.checked = $(el).hasClass('liked');

        this.timeline = new mojs.Timeline();

        for (var i = 0, len = this.options.tweens.length; i < len; ++i) {
            this.timeline.add(this.options.tweens[i]);
        }

        var self = this;
        this.el.addEventListener(clickHandler, function () {
            if (self.checked) {
                self.options.onUnCheck();
            }
            else {
                self.options.onCheck();
                self.timeline.start();
            }
            self.checked = !self.checked;
        });
    }

    Animocon.prototype.options = {
        tweens: [
            new mojs.Burst({
                shape: 'circle',
                isRunLess: true
            })
        ],
        onCheck: function () {
            return false;
        },
        onUnCheck: function () {
            return false;
        }
    };
</script>

@stack('scripts')

@if(Auth::check())
	<script src="{{ asset('js/dropzone.min.js') }}"></script>
	<script>
        var uploadedImages = [];
        var composedTags = [];
        var caption = '';
        var checking = false;

        Dropzone.options.composerDropzone = {
            paramName: "file",
            maxFilesize: 5,
            thumbnailWidth: 130,
            thumbnailHeight: 130,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            maxFiles: 6,
            dictFileTooBig: "@lang('messages.composer.dropzone.too-big')",
            dictInvalidFileType: "@lang('messages.composer.dropzone.invalid')",
            dictCancelUpload: "@lang('messages.composer.dropzone.cancel')",
            dictRemoveFile: "@lang('messages.composer.dropzone.remove')",
            dictMaxFilesExceeded: "@lang('messages.composer.dropzone.max')",
            init: function () {
                var $this = this;
                $this.on("complete", function (file) {
                    if (!file.accepted || file.status == "error") {
                        setTimeout(function () {
                            $this.removeFile(file);
                        }, 3500);
                        return;
                    }

                    var $url = JSON.parse(file.xhr.response).path;
                    uploadedImages.push($url);

                    if ($('a.composer-post').hasClass('disabled'))
                        toggleComposerPostButton();
                });

                $this.on("removedfile", function (file) {
                    if (!file.accepted || file.status == "error")
                        return;

                    var removedUrl = JSON.parse(file.xhr.response).path;
                    uploadedImages = uploadedImages.filter(function (item) {
                        return item != removedUrl;
                    });

                    if (uploadedImages.length == 0) {
                        if (!$('a.composer-post').hasClass('disabled'))
                            toggleComposerPostButton();
                    }
                });
            }
        }

        // Toggle post button state.
        function toggleComposerPostButton() {
            $('.composer a.composer-post').toggleClass('disabled');
        }

        // Done composing.
        function doneCompose() {
            if (uploadedImages.length == 0)
                return false;

            $('.composer').addClass('posting');

            setTimeout(function () {
                $.post({
                    url: '{{ route('post-new', [], false) }}',
                    data: {
                        _token: Laravel.csrfToken,
                        media: uploadedImages,
                        caption: $composerVm.captionText,
                        tags: composedTags
                    },
                    success: function (status) {
                        if (status.status != 'success')
                            return false;

                        setTimeout(function () {
                            window.location.reload();
                        }, 100);
                    },
                    error: function () {
                        displayErrorMessage();
                    },
                    complete: function () {
                        $('.composer').removeClass('posting');
                    }
                });
            }, 100);
        }

        function toggleComposer() {
            var $composer = $('body > .composer');

            if ($($composer).hasClass('open')) {
                $('body > .composer > .composer-box').toggleClass('bounceOut');
                setTimeout(function () {
                    $('body > .full-overlay').removeClass('present');
                    $($composer).removeClass('open');
                    $('body > .composer > .composer-box').toggleClass('bounceOut');
                }, 750);
            } else {
                $('body > .full-overlay').addClass('present');
                $($composer).addClass('open');
            }
        }

        function clickToggleComposer(e) {
            e.preventDefault();

            toggleComposer();

            return false;
        }

        // Check in request.
        function checkin(e) {
            if (checking)
                return false;

            checking = true;

            e.target.classList.add('disabled');
            $vm.request({
                url: '{{ route('checkin') }}',
                type: 'POST',
                callback: function (success) {
                    if (success) {
                        checkedIn(e);
                        $vm.User.checkedIn = true;
                        $(e.target).off('click');
                    }
                },
                complete: function () {
                    checking = false;
                    e.target.classList.remove('disabled');
                }
            });
        }

        // Play check in animation.
        function checkedIn(e) {
            var burst = new mojs.Burst({
                parent: e.target,
                radius: {0: 120},
                count: 8,
                opacity: {1:0},
                x: -50,
                y: -55,
                fill: '#112946',
                stroke: '#112946',
                strokeWidth: {5: 0},
            });
        }

        // When it's ready.
        $(document).ready(function () {
            // Bind composer events.
            $('#compose-new').on('click', clickToggleComposer);
            $('.flying-buttons .compose-new').on('click', clickToggleComposer);
            $('.composer-actions .composer-cancel').on('click', clickToggleComposer);
            $('.composer .close-button').on('click', clickToggleComposer);
            $('.composer .composer-post').on('click', doneCompose);
            $('.checkin:not(.completed) .checkin-button button').on('click', checkin);

            // Bind 'back to top' button events
            $('#back-to-top').on('click', function () {
                $('html,body').animate({scrollTop: 0}, 600, 'swing');
            });
            $(window).scroll(function () {
                var $top = document.getElementById('back-to-top');

                if ($(this).scrollTop() <= 500) {
                    if (!$($top).hasClass('hidden')) {
                        $top.classList.add('bounceOut');
                        setTimeout(function () {
                            $top.classList.remove('bounceOut');
                            $top.classList.add('hidden');
                        }, 1000);
                    }
                } else {
                    $top.classList.remove('hidden');
                }
            });

            // Set up Emoji One Caption.
            $('#composer-comment-area').emojioneArea({
                pickerPosition: "top",
                tonesStyle: "bullet",
                inline: true,
                placeholder: "@lang('messages.composer.caption-placeholder') ✍️ ...",
                events: {
                    // Bind comment text to compose new.
                    change: function (editor, event) {
                        $composerVm.captionText = editor[0].innerHTML;
                    }
                }
            });

            // Set up Taggle for hashtags.
            new Taggle('composer-tags-input', {
                duplicateTagClass: 'bounce',
                placeholder: '@lang('messages.composer.hashtag-placeholder') ...',
                onTagAdd: function (event, tag) {
                    composedTags.push(tag);
                },
                onTagRemove: function (event, tag) {
                    composedTags = composedTags.filter(function (item) {
                        return item != tag;
                    });
                }
            });

            $('.material-select').material_select();
        });
	</script>
@endif

<script>
    toastr.options = {
        'progressBar': true,
        'showEasing': "swing",
        'hideEasing': "swing",
        'showMethod': "fadeIn",
        'hideMethod': "fadeOut",
        "showDuration": 300,
        "hideDuration": 1000,
        "timeOut": 8000,
        "closeButton": false
    }

    function displayStatus(type, message) {
        setTimeout(function () {
            toastr[type](message);
        }, 350);
    }

			@if(session('status'))
    var alert = {!! json_encode(session('status')) !!};

    if (alert.type)
        displayStatus(alert.type, alert.message);
    else
        displayStatus('success', alert.message);
	@endif
</script>
</body>
</html>
