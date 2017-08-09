@include('layouts.header')
<body>
    <!-- Add 'present' class -->
    <div class="full-overlay"></div>

    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/logo-light.png" alt="Logo">
                        {{ config('app.name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#" title="Home">
                                <i class="fa fa-home"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Privacy">
                                <i class="fa fa-user-secret"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Help">
                                <i class="fa fa-question-circle"></i>
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li>
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">Register</a>
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
                                        <i class="fa fa-cogs"></i>&nbsp;Admin
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="#" class="menu-link">
                                        <i class="fa fa-user-circle-o"></i>&nbsp;Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="menu-link">
                                        <i class="fa fa-check-circle-o"></i>&nbsp;Achievements
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
                                        <button>Check in</button>
                                    </div>
                                </li>
                                <li class="divider" role="separator"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="menu-link">
                                            <i class="fa fa-sign-out"></i>&nbsp;Sign out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
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
                            <a href="#" id="compose-new" class="composer-new">
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
    <div class="composer"><!-- add 'open' -->
        {{--<div class="composer-box animated fadeInDown">--}}
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
                        <span>Add images by dragging files here or selecting...</span>
                        <br>
                        <span>(Only allows 6 images maximum, each smaller than 2 MB)</span>
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
                <a class="composer-cancel" href="#">Cancel</a>
                <a class="composer-post disabled" href="javascript:void(0)">Post</a>
            </a>
        </div>
    </div>
    @endif

    <!-- Footer section -->
    <footer>

    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/emojionearea.min.js') }}"></script>
    <script src="{{ asset('js/taggle.js') }}"></script>
    <script src="{{ voyager_asset('lib/js/toastr.min.js') }}"></script>

    @stack('scripts')

    @if(Auth::check())
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script>
        var uploadedImages = [];
        var composedTags = [];
        var caption = '';

        Dropzone.options.composerDropzone = {
            paramName: "file",
            maxFilesize: 4,
            thumbnailWidth: 130,
            thumbnailHeight: 130,
            acceptedFiles: 'image/*,video/*',
            addRemoveLinks: true,
            maxFiles: 6,
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
                    }, 500);
                },
                error: function () {
                    toastr.error('Something went wrong, try again.')
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
            $('.composer-actions .composer-cancel').on('click', clickToggleComposer);
            $('.composer .close-button').on('click', clickToggleComposer);
            $('.composer .composer-post').on('click', doneCompose);

            // Set up Emoji One Caption.
            $('#composer-comment-area').emojioneArea({
                pickerPosition: "top",
                tonesStyle: "bullet",
                inline: true,
                placeholder: "Add a comment ✍ ...",
                useSprite: true
            });

            // Set up Taggle for hashtags.
            new Taggle('composer-tags-input', {
                duplicateTagClass: 'bounce',
                placeholder: 'Enter #hashtags 🙌 without "#"',
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
