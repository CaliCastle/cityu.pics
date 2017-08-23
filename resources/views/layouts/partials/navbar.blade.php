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
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" v-cloak>
							<img :src="User.avatarUrl" alt="Avatar" class="img-responsive img-circle nav-avatar">
							&nbsp;@{{ User.name }}&nbsp;<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="rank">
								<!-- TODO: change color -->
								<span class="rank-icon rank-label" data-rank="5"></span>
								<span class="exp-label" v-cloak>@{{ User.experience }}</span>
							</li>
							@if(Auth::user()->hasPermission('browse_admin'))
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
									<i class="fa fa-heart"></i>&nbsp;@lang('messages.navbar.user-menu.liked')
								</a>
							</li>
							<li>
								<a href="{{ route('settings') }}" class="menu-link">
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
					<li class="dropdown">
						<a href="#" class="notif-button animated" data-toggle="dropdown" role="button" aria-expanded="false">
							<i class="fa" :class="{'fa-bell': User.unread, 'fa-bell-o': !User.unread}"></i>
							<span class="badge badge-success pull-right unread-{{ Auth::user()->unread }}" :class="'unread-'+User.unread" v-show="User.unread" v-cloak>@{{ User.unread }}</span>
						</a>
						@include('layouts.partials.inbox')
					</li>
					<li class="search-container">
						<a href="#" class="btn-search" id="btn-search">
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