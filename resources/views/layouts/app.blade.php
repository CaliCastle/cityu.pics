@include('layouts.header')
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
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
                        {{--@if (Auth::guest())--}}
                            {{--<li><a href="{{ route('login') }}">
                                <i class="fa.fa-login"></i>
                            </a></li>--}}
                        {{--@else--}}
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src="/avatar.png" alt="Avatar" class="img-responsive img-circle nav-avatar">
                                &nbsp;Cali Castle
                            </a>
                            <ul class="dropdown-menu">
                                <li class="rank">
                                    <!-- TODO: change color -->
                                    <span class="rank-icon rank-label" data-rank="5"></span>
                                    <span class="exp-label">Exp: 1,500</span>
                                </li>
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
                                        <span class="month">Jul</span>
                                        <span class="date">25</span>
                                    </div>
                                    <div class="checkin-button">
                                        <button>Check in</button>
                                    </div>
                                </li>
                                <li class="divider" role="separator"></li>
                                <li>
                                    <a href="#" class="menu-link">
                                        <i class="fa fa-sign-out"></i>&nbsp;Sign out
                                    </a>
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
                            <a href="#">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </li>
                        {{--@endif--}}
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
