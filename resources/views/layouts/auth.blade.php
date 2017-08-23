<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="author" content="Cali Castle">
	<meta name="description" content="@lang('messages.app.slogan')">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title') :: {{ trans('messages.app.slogan') }}</title>

	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">

	@stack('styles')

	<script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        document.documentElement.className = 'js';
	</script>

	<!-- Icons -->
	<link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/icons/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
	<link rel="icon" type="image/x-icon" href="/logo.png">
	<link rel="shortcut icon" type="image/x-icon" href="/logo.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/icons/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<meta property="og:url" content="{{ url()->current() }}"/>
	<meta property="og:title" content="@yield('title') :: {{ trans('messages.app.slogan') }}"/>
	<meta property="og:description" content="@lang('messages.app.slogan')"/>
	<meta property="og:image"
	      content="@if(View::hasSection('og:image'))@yield('og:image')@else{{ asset('images/cityu.jpg') }}@endif"/>

	@stack('meta')
</head>

<body class="auth">

<div class="container-fluid">
	<div class="row">
		<div class="faded-bg animated"></div>
		<div class="language-switch dropdown animated bounceInDown">
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
		</div>
		<div class="hidden-xs col-sm-8 col-md-9">
			<div class="clearfix">
				<div class="col-sm-12 col-md-10 col-md-offset-2">
					<div class="logo-title-container">
                        <?php $admin_logo_img = Voyager::setting('admin_icon_image', ''); ?>
						@if($admin_logo_img == '')
							<img class="img-responsive pull-left logo hidden-xs animated fadeIn" src="/logo-light.png"
							     alt="Logo Icon">
						@else
							<img class="img-responsive pull-left logo hidden-xs animated fadeIn"
							     src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
						@endif
						<div class="copy animated fadeIn">
							<h1>{{ Voyager::setting('admin_title', 'CityU Pics') }}</h1>
							<p>@lang('messages.auth.background-description')</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		@yield('sidebar')

	</div> <!-- .login-sidebar -->
</div> <!-- .row -->
</div> <!-- .container-fluid -->
<script>
	(function () {
		document.querySelector('.language-switch .dropdown-toggle').addEventListener('click', function (e) {
		    e.preventDefault();
			e.target.classList.toggle('open');
        });
    })(window);
</script>
@stack('scripts')
</body>
</html>