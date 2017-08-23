@extends('layouts.app')

@section('title', trans('messages.titles.settings'))

@section('content')
	<div class="settings-content">
		<div class="container">
			<div class="settings-panel">
				<div class="settings-panel__content">
					<h2>@lang('messages.titles.settings')</h2>
					<div class="settings-panel__form-wrapper">
						<div class="divider"></div>
						<form action="{{ route('settings') }}" method="POST" class="col s12 ajax">
							{!! csrf_field() !!}
							<div class="row">
								<div class="col s12 l6">
									{{-- Name --}}
									<div class="input-field">
										<i class="fa fa-user-circle-o prefix"></i>
										<input type="text" id="name" v-model="User.name">
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
										<input type="password" id="password">
										<label for="password">@lang('messages.settings.password')</label>
									</div>
									<div class="input-field">
										<i class="fa fa-key prefix"></i>
										<input type="password" id="password">
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
											<input class="with-gap" type="radio" id="gender-{{ $gender }}" name="gender[]"{{ Auth::user()->gender == $gender ? ' checked' : '' }}>
											<label for="gender-{{ $gender }}"><i class="fa fa-{{ \App\User::genderToIcon($gender) }}"></i>&nbsp;{{ trans('messages.settings.gender-options.' . $gender) }}</label>
										</p>
									@endforeach
								</div>
							</div>
							<div class="row">
								<button class="col s12 m8 l4 offset-m2 offset-l4 btn btn-block waves-effect waves-light" type="submit">@lang('auth.input.submit')<i class="fa fa-paper-plane right"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop