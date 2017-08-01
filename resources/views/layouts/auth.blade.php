@include('layouts.header')

<body class="auth">

    <div class="container-fluid">
        <div class="row">
            <div class="faded-bg animated"></div>
            <div class="hidden-xs col-sm-8 col-md-9">
                <div class="clearfix">
                    <div class="col-sm-12 col-md-10 col-md-offset-2">
                        <div class="logo-title-container">
                            <?php $admin_logo_img = Voyager::setting('admin_icon_image', ''); ?>
                            @if($admin_logo_img == '')
                                <img class="img-responsive pull-left logo hidden-xs animated fadeIn" src="/logo-light.png" alt="Logo Icon">
                            @else
                                <img class="img-responsive pull-left logo hidden-xs animated fadeIn" src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                            @endif
                            <div class="copy animated fadeIn">
                                <h1>{{ Voyager::setting('admin_title', 'CityU Pics') }}</h1>
                                <p>{{ Voyager::setting('admin_description', 'Welcome to CityU Pics. The Picture Sharing Site for CityU') }}</p>
                            </div>
                        </div> <!-- .logo-title-container -->
                    </div>
                </div>
            </div>

            @yield('sidebar')

            </div> <!-- .login-sidebar -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
    @stack('scripts')
</body>
</html>