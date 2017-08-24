@extends('layouts.app')

@section('title', trans('messages.titles.settings'))

@section('content')
	<div class="settings-content">
		<div class="container">
			<div class="tabs-wrapper col s12">
				<ul class="tabs">
					<li class="tab col s4"><a href="#personal" class="active">@lang('messages.settings.tabs.personal')</a></li>
					<li class="tab col s4"><a href="#privacy">@lang('messages.settings.tabs.privacy')</a></li>
					<li class="tab col s4"><a href="#feed">@lang('messages.settings.tabs.feed')</a></li>
				</ul>
			</div>
			<div class="settings-panel">
				<div class="settings-panel__content" id="personal">
					<h2>@lang('messages.settings.tabs.personal')</h2>
					<div class="settings-panel__form-wrapper">
						<div class="divider"></div>
						<form action="{{ route('settings.personal') }}" method="POST" class="col s12 ajax">
							{!! csrf_field() !!}
							<div class="row">
								<div class="col s12 l6">
									{{-- Name --}}
									<div class="input-field">
										<i class="fa fa-user-circle-o prefix"></i>
										<input type="text" id="name" name="name" v-model="User.name" required>
										<label for="name">@lang('messages.auth.register.name')</label>
									</div>
									{{-- Email (disabled) --}}
									<div class="input-field">
										<i class="fa fa-at prefix"></i>
										<input type="email" id="email" v-model="User.email" disabled>
										<label for="email">@lang('messages.settings.email')</label>
									</div>
								</div>
								<div class="col s12 l6">
									{{-- Password --}}
									<div class="input-field">
										<i class="fa fa-key prefix"></i>
										<input type="password" id="password" name="password">
										<label for="password">@lang('messages.settings.password')</label>
									</div>
									<div class="input-field">
										<i class="fa fa-key prefix"></i>
										<input type="password" id="password" name="password_confirmation">
										<label for="password">@lang('messages.auth.register.password-confirm')</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									{{-- Description --}}
									<div class="input-field">
										<i class="fa fa-pencil prefix"></i>
										<textarea class="materialize-textarea" id="description" name="description" v-model="User.description" data-length="120"></textarea>
										<label for="description">@lang('messages.settings.description')</label>
									</div>									
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									{{-- Gender --}}
									<span class="input-heading"><i class="fa fa-venus-mars"></i>&nbsp;@lang('messages.settings.gender')</span>
									@foreach(\App\User::genderTypes() as $gender)
										<p>
											<input class="with-gap" type="radio" id="gender-{{ $gender }}" name="gender" value="{{ $gender }}" {{ Auth::user()->gender == $gender ? ' checked' : '' }}>
											<label for="gender-{{ $gender }}"><i class="fa fa-{{ \App\User::genderToIcon($gender) }}"></i>&nbsp;{{ trans('messages.settings.gender-options.' . $gender) }}</label>
										</p>
									@endforeach
								</div>
							</div>
							<div class="row">
								<button class="col s12 m8 l4 offset-m2 offset-l4 btn btn-block indigo darken-1 white-text waves-effect waves-light" type="submit">@lang('auth.input.submit')<i class="fa fa-paper-plane right"></i></button>
							</div>
						</form>
					</div>
				</div>
				<div class="settings-panel__content" id="privacy">
					<h2>@lang('messages.settings.tabs.privacy')</h2>
					<div class="settings-panel__form-wrapper">
						<div class="divider"></div>
						<form action="{{ route('settings.privacy') }}" method="POST" class="col s12 ajax">
							{!! csrf_field() !!}
							<div class="row">
								<div class="col s12">
									<div class="left">
										<b>@lang('messages.settings.display-email')</b>
									</div>
									<div class="switch right">
										<label>
											@lang('messages.settings.switches.off')
											<input type="checkbox" name="display_email" {{ Auth::user()->display_email ? 'checked' : '' }}>
											<span class="lever"></span>
											@lang('messages.settings.switches.on')
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col s12">
									<div class="left">
										<b>@lang('messages.settings.subscribe')</b>
									</div>
									<div class="switch right">
										<label>
											@lang('messages.settings.switches.off')
											<input type="checkbox" name="subscribe" {{ Auth::user()->subscribe ? 'checked' : '' }}>
											<span class="lever"></span>
											@lang('messages.settings.switches.on')
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<button class="col s12 m8 l4 offset-m2 offset-l4 btn btn-block indigo darken-1 white-text waves-effect waves-light" type="submit">@lang('auth.input.submit')<i class="fa fa-paper-plane right"></i></button>
							</div>
						</form>
					</div>
				</div>
				<div class="settings-panel__content" id="feed">
					<h2>@lang('messages.settings.tabs.feed')</h2>
					<div class="settings-panel__form-wrapper">
						<div class="divider"></div>
						<form action="{{ route('settings.feed') }}" method="POST" class="col s12 ajax">
							<div class="row">
								<div class="col s12">
									<div class="left"><b>@lang('messages.settings.feed-filter')</b></div>
									<div class="switch right">
										<label>
											@lang('messages.settings.switches.off')
											<input type="checkbox" name="feed_filter" {{ Auth::user()->feed_filter ? 'checked' : '' }}>
											<span class="lever"></span>
											@lang('messages.settings.switches.on')
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<button class="col s12 m8 l4 offset-m2 offset-l4 btn btn-block indigo darken-1 white-text waves-effect waves-light" type="submit">@lang('auth.input.submit')<i class="fa fa-paper-plane right"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop