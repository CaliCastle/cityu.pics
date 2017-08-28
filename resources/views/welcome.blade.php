@extends('layouts.app')

@section('title', trans('messages.titles.welcome'))

@push('styles')
	<link rel="stylesheet" href="{{ asset('css/square-loader.min.css') }}">
@endpush

@section('content')
	<header class="header">
		<div class="language-links dropdown animated fadeIn">
			<a href="#" class="animated dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
				<img src="{{ asset('images/locale-' . app()->getLocale())  }}.png" alt="" class="locale-img">
				&nbsp;
				@lang('languages.' . app()->getLocale())
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				@foreach(trans('languages') as $lang => $string)
					@if($lang != app()->getLocale())
						<li>
							<a href="{{ route('language', ['language' => $lang]) }}" class="menu-link waves-effect waves-light">
								<img src="{{ asset('images/locale-' . $lang) }}.png" alt="" class="locale-img locale-selector">
								<span>@lang('languages.' . $lang)</span>
							</a>
						</li>
					@endif
				@endforeach
			</ul>
		</div>
		<nav class="links animated fadeIn">
			@if(Auth::guest())
			<a class="link__item" href="{{ url('login') }}">@lang('auth.login')</a>
			<a class="link__item" href="{{ url('register') }}">@lang('auth.register')</a>
			@else
			<div class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					<img src="{{ Auth::user()->avatarUrl }}" alt="Avatar" class="img-responsive circle nav-avatar">
					&nbsp;{{ Auth::user()->name }}&nbsp;<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					@if(Auth::user()->hasPermission('browse_admin'))
						<li>
							<a href="{{ route('voyager.dashboard') }}" class="menu-link waves-effect waves-light" target="_blank">
								<i class="fa fa-cogs"></i>&nbsp;@lang('messages.navbar.user-menu.admin')
							</a>
						</li>
					@endif
					<li>
						<a href="{{ Auth::user()->profileLink() }}" class="menu-link waves-effect waves-light">
							<i class="fa fa-user-circle-o"></i>&nbsp;@lang('messages.navbar.user-menu.profile')
						</a>
					</li>
					<li>
						<a href="{{ route('settings') }}" class="menu-link waves-effect waves-light">
							<i class="fa fa-cog"></i>&nbsp;@lang('messages.navbar.user-menu.settings')
						</a>
					</li>
					<li>
						<form action="{{ route('logout') }}" method="POST">
							{{ csrf_field() }}
							<button type="submit" class="menu-link waves-effect waves-light signout" role="button">
								<i class="fa fa-power-off"></i>&nbsp;@lang('messages.navbar.user-menu.signout')
							</button>
						</form>
					</li>
				</ul>
			</div>
			<a class="link__item" href="{{ url('feed') }}"><i class="fa fa-compass"></i>&nbsp;@lang('messages.titles.feed')</a>
			@endif
		</nav>
	</header>
	<section class="page page--mover">
		<div class="la-square-jelly-box la-2x"><div></div><div></div></div>
	</section>
	<div class="title-wrap">
		<img src="{{ asset('logo-light.png') }}" alt="Logo">
		<h1 class="title title--main animated fadeIn">@lang('messages.welcome.introduction')</h1>
		<p class="title title--sub animated fadeIn"><i class="fa fa-magic"></i>&nbsp;@lang('messages.app.slogan')</p>
	</div>
	<section class="page page--static">
		<div class="page__title">
			<h2 class="page__title-main"><i class="fa fa-fire"></i>&nbsp;@lang('messages.welcome.popular')</h2>
			<p class="page__title-sub">
				@if(Auth::guest())
				@lang('messages.welcome.subtitle', ['url' => url('register')])
				@else
					<a href="{{ route('feed') }}" class="btn white-text purple darken-1">@lang('messages.welcome.show-feed')</a>
				@endif
			</p>
		</div>
		<ul class="grid">
			@foreach($posts as $post)
			<li class="grid__item">
				<a class="grid__link" href="{{ $post->link() }}">
					<div class="grid__img" style="background-image: url({{ $post->firstImageUrl() }})"></div>
					<div class="grid__user">
						<img class="grid__avatar circle" src="{{ $post->user->avatarUrl }}">
						<h4 class="grid__name text-left">{{ $post->user->name }}</h4>
					</div>
					<p class="grid__item-title"><i class="fa fa-heart"></i>&nbsp;{{ trans_choice('messages.welcome.likes', $post->likes()->count(), ['like' => $post->likes]) }}</p>
				</a>
			</li>
			@endforeach
		</ul>
	</section>
	<section class="content content--full flexy flexy--row overflow-hidden" id="share">
		<h2 class="content__title content--half text-right">
			<div id="share-title1" class="content__title__inner white-text">@lang('messages.welcome.share.top')</div><br/>
			<div id="share-title2" class="content__title__inner content__title__inner--offset-2 red-text">@lang('messages.welcome.share.bottom')</div>
		</h2>
		<div id="share-image" class="content__image-wrap content--half" style="opacity: 0;"></div>
	</section>
	<section class="content flexy flexy--row overflow-hidden" id="comment">
		<div id="comment-image" class="content__image-wrap content--half" style="opacity: 0;"></div>
		<h2 class="content__title content--half text-left">
			<div id="comment-title1" class="content__title__inner yellow-text">@lang('messages.welcome.comment.top')</div>
			<br>
			<div id="comment-title2" class="content__title__inner light-blue-text text-lighten-2">@lang('messages.welcome.comment.bottom')</div>
		</h2>
	</section>
	<section class="content flexy flexy--row overflow-hidden" id="inbox">
		<h2 class="content__title content--half text-right">
			<div id="inbox-title1" class="content__title__inner purple-text text-lighten-2">@lang('messages.welcome.inbox.top')</div>
			<br>
			<div id="inbox-title2" class="content__title__inner content__title__inner--offset-2 grey-text text-lighten-3">@lang('messages.welcome.inbox.bottom')</div>
		</h2>
		<div id="inbox-image" class="content__image-wrap content--half" style="opacity: 0;"></div>
	</section>
	<section id="checkin" class="content flexy flexy--row overflow-hidden">
		<div id="checkin-image" class="content__image-wrap content--half" style="opacity: 0;"></div>
		<h2 class="content__title content--half text-center">
			<div id="checkin-title1" class="content__title__inner light-green-text text-lighten-2">@lang('messages.welcome.checkin.top')</div>
			<br>
			<div id="checkin-title2" class="content__title__inner blue-grey-text text-lighten-5">@lang('messages.welcome.checkin.bottom')</div>
		</h2>
	</section>
	<section id="languages" class="content flexy overflow-hidden">
		<h2 class="content__title text-center">
			<div id="languages-title1" class="content__title__inner teal-text text-darken-3 animated fadeInDown" style="display: none;"><i class="fa fa-language"></i>&nbsp;@lang('messages.welcome.languages.top')</div>
			<br><br>
			<div id="languages-title2" class="content__title__inner deep-orange-text text-darken-4 animated fadeInUp" style="display: none;">@lang('messages.welcome.languages.bottom') <a href="{{ url('contribute') }}" target="_blank">@lang('messages.footer.dev.contribute')</a></div>
		</h2>
	</section>
	@include('layouts.footer')
	<div class="device">
		<div class="device__screen"></div>
	</div>
	<button id="showgrid" class="button button--view" aria-label="Show me more">
		<svg width="100%" height="100%" viewBox="0 0 310 177" preserveAspectRatio="xMidYMid meet">
			<path fill="#FFFFFF" d="M159.875,174.481L306.945,27.41c2.93-2.929,2.93-7.678,0-10.606L292.803,2.661c-1.406-1.407-3.314-2.197-5.303-2.197c-1.989,0-3.896,0.79-5.303,2.197L154.572,130.287L26.946,2.661c-1.406-1.407-3.314-2.197-5.303-2.197c-1.989,0-3.897,0.79-5.303,2.197L2.197,16.804C0.733,18.269,0,20.188,0,22.107s0.732,3.839,2.197,5.303l147.071,147.071C152.197,177.411,156.945,177.411,159.875,174.481L159.875,174.481z" />
		</svg>
	</button>

	<script src="{{ asset('js/dynamics.min.js') }}"></script>
	<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{ asset('js/anime.min.js') }}"></script>
	<script src="{{ asset('js/scrollMonitor.min.js') }}"></script>
	<script src="{{ asset('js/welcome.js') }}"></script>
@endsection