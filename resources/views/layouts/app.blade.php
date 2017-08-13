@include('layouts.header')
<body>
    <div class="post-overlay"></div>
    <div class="full-overlay"></div>

    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">@lang('messages.navbar.sr-only')</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/logo-light.png" alt="Logo">
                        <span>{{ config('app.name') }}</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li>
                                <a href="{{ route('login') }}">@lang('auth.login')</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">@lang('auth.register')</a>
                            </li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src="{{ Voyager::image(($user = Auth::user())->avatar) }}" alt="Avatar" class="img-responsive img-circle nav-avatar">
                                &nbsp;{{ $user->name }}&nbsp;<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="rank">
                                    <!-- TODO: change color -->
                                    <span class="rank-icon rank-label" data-rank="5"></span>
                                    <span class="exp-label">Exp: {{ $user->experience }}</span>
                                </li>
                                @if($user->hasPermission('browse_admin'))
                                <li>
                                    <a href="{{ route('voyager.dashboard') }}" class="menu-link" target="_blank">
                                        <i class="fa fa-cogs"></i>&nbsp;@lang('messages.navbar.user-menu.admin')
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ Auth::user()->profileLink() }}" class="menu-link">
                                        <i class="fa fa-user-circle-o"></i>&nbsp;@lang('messages.navbar.user-menu.profile')
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="menu-link disabled">
                                        <i class="fa fa-cog"></i>&nbsp;@lang('messages.navbar.user-menu.settings')
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="menu-link disabled">
                                        <i class="fa fa-check-circle-o"></i>&nbsp;@lang('messages.navbar.user-menu.achievements')
                                    </a>
                                </li>
                                <li class="divider" role="separator"></li>
                                <li class="checkin"><!-- class="completed" -->
                                    <i class="fa fa-calendar-o"></i>
                                    <div class="today">
                                        <span class="month">{{ \Carbon\Carbon::today()->format('M') }}</span>
                                        <span class="date">{{ \Carbon\Carbon::today()->day }}</span>
                                    </div>
                                    <div class="checkin-button">
                                        <button>@lang('messages.navbar.user-menu.checkin')</button>
                                    </div>
                                </li>
                                <li class="divider" role="separator"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="menu-link signout">
                                            <i class="fa fa-power-off"></i>&nbsp;@lang('messages.navbar.user-menu.signout')
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <img src="{{ asset('images/locale-' . app()->getLocale())  }}.png" alt="" class="locale-img">
                                    &nbsp;
                                @lang('languages.' . app()->getLocale())
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(trans('languages') as $lang => $string)
                                    @if($lang != app()->getLocale())
                                    <li>
                                        <a href="{{ route('language', ['language' => $lang]) }}" class="menu-link">
                                            <img src="{{ asset('images/locale-' . $lang) }}.png" alt="" class="locale-img locale-selector">
                                            <span>@lang('languages.' . $lang)</span>
                                        </a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        <li>
                            <a href="#" class="notif-button">
                                <i class="fa fa-bell-o"></i>
                            </a>
                        </li>
                        <li class="search-container">
                            <a href="#">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="compose-new" class="composer-new" title="@lang('messages.navbar.compose-new')" style="color: #f3e25c !important">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

    </div>

    @if(Auth::check())
    <div class="composer">
        <div class="composer-box animated bounceIn">
            <div class="composer-user-section">
                <img class="img-circle" src="{{ Voyager::image($user->avatar) }}" alt="{{ $user->name }}">
                <b>{{ $user->name }}:</b>
                <a href="#" class="close-button">
                    <i class="fa fa-close"></i>
                </a>
            </div>
            <div class="composer-images-section">
                <form class="dropzone" id="composer-dropzone" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
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

    <!-- Footer section -->
    <footer>

    </footer>

    <div class="flying-buttons">
        <a class="flying-button compose-new animated jackInTheBox" href="javascript:void(0)" title="@lang('messages.navbar.compose-new')" data-toggle="tooltip" data-placement="left">
            <span class="fa fa-plus"></span>
        </a>
        <a class="flying-button animated bounceIn hidden" href="javascript:void(0)" id="back-to-top">
            <span class="fa fa-chevron-up"></span>
        </a>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?v={{ config('app.version') }}"></script>
    <script src="{{ asset('js/emojionearea.min.js') }}"></script>
    <script src="{{ asset('js/taggle.js') }}"></script>
    <script src="{{ voyager_asset('lib/js/toastr.min.js') }}"></script>
    <script>
        function displayErrorMessage() {
            toastr.error('Something went wrong, try again.');
        }
    </script>

    @stack('scripts')

    @if(Auth::check())
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script>
        var uploadedImages = [];
        var composedTags = [];
        var caption = '';

        Dropzone.options.composerDropzone = {
            paramName: "file",
            maxFilesize: 5,
            thumbnailWidth: 130,
            thumbnailHeight: 130,
            acceptedFiles: 'image/*,video/*',
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

        function toggleComposerPostButton() {
            $('.composer a.composer-post').toggleClass('disabled');
        }

        function doneCompose() {
            caption = $('.emojionearea-editor').html();

            if (uploadedImages.length == 0)
                return false;

            $('.composer').addClass('posting');
            $.post({
                url: '{{ route('post-new', [], false) }}',
                data: {
                    _token: Laravel.csrfToken,
                    media: uploadedImages,
                    caption: caption,
                    tags: composedTags
                },
                success: function (status) {
                    if(status.status != 'success')
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

        $(document).ready(function () {
            // Bind composer events.
            $('#compose-new').on('click', clickToggleComposer);
            $('.flying-buttons .compose-new').on('click', clickToggleComposer);
            $('.composer-actions .composer-cancel').on('click', clickToggleComposer);
            $('.composer .close-button').on('click', clickToggleComposer);
            $('.composer .composer-post').on('click', doneCompose);

            // Bind 'back to top' button events
            $('#back-to-top').on('click', function () {
                $('body').animate({scrollTop: 0}, 600, 'swing');
            });
            $(window).scroll(function() {
                var $top = document.getElementById('back-to-top');

                if ($(this).scrollTop() <= 500) {
                    $top.classList.add('hidden');
                } else {
                    $top.classList.remove('hidden');
                }
            });
//            $('[data-toggle="tooltip"]').tooltip();

            // Set up Emoji One Caption.
            $('#composer-comment-area').emojioneArea({
                pickerPosition: "top",
                tonesStyle: "bullet",
                inline: true,
                placeholder: "@lang('messages.composer.caption-placeholder')  ✍ ...",
                useSprite: true
            });

            // Set up Taggle for hashtags.
            new Taggle('composer-tags-input', {
                duplicateTagClass: 'bounce',
                placeholder: '🖐  @lang('messages.composer.hashtag-placeholder') ...',
                onTagAdd: function (event, tag) {
                    composedTags.push(tag);
                },
                onTagRemove: function (event, tag) {
                    composedTags = composedTags.filter(function (item) {
                        return item != tag;
                    });
                }
            });
        });
    </script>
    @endif

    <script>
        toastr.options = {
            'progressBar': true,
            'showEasing': "swing",
            'hideEasing': "linear",
            'showMethod': "fadeIn",
            'hideMethod': "fadeOut"
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
