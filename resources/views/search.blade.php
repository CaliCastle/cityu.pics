@extends('layouts.app')

@section('title', trans('messages.titles.search', compact('query')))

@section('content')
	<div class="search-content">
		<div class="container">
			<div class="row">
				<h2 class="panel-heading white-text center"><i class="fa fa-search"></i> @lang('messages.titles.search', compact('query'))</h2>
			</div>
			<div class="row">
				<h3 class="panel-heading lime-text"><i class="fa fa-tags"></i> @lang('messages.search.related-tags'):</h3>
				@forelse($tags as $i => $tag)
					<a href="{{ $tag->link() }}" class="chip no-decoration">
						#{{ $tag->name }} ({{ $tag->relatedPostsCount() }})
					</a>
				@empty
					<h4 class="center white-text"><i class="fa fa-times-circle"></i> @lang('messages.search.none-found')</h4>
				@endforelse
			</div>
			<div class="row">
				<h3 class="panel-heading cyan-text"><i class="fa fa-user-circle"></i> @lang('messages.search.related-users'):</h3>
				<ul class="collection">
					@forelse($users as $i => $user)
					<li class="collection-item avatar waves-effect">
						<a href="{{ $user->profileLink() }}" class="no-decoration">
							<img src="{{ $user->avatarUrl }}" alt="{{ $user->name }}" class="circle">
							<span class="title white-text">{{ $user->name }}</span>
							<p class="teal-text">{!! trans_choice('messages.profile.followers', $user->followers, ['count' => $user->followers]) !!}</p>
							<p class="green-text">{{ $user->posts()->count() }} {{ trans_choice('messages.search.posts', $user->posts()->count()) }}</p>
						</a>
					</li>
					@empty
						<h4 class="center white-text"><i class="fa fa-times-circle"></i> @lang('messages.search.none-found')</h4>
					@endforelse
				</ul>
			</div>
			<div class="row feed-content">
				<h3 class="panel-heading orange-text"><i class="fa fa-file-text"></i> @lang('messages.search.related-posts'):</h3>
				@if($posts->count())
				@include('layouts.feed-layout')
				@else
				<h4 class="center white-text"><i class="fa fa-times-circle"></i> @lang('messages.search.none-found')</h4>
				@endif
			</div>
		</div>
	</div>
@stop

@push('scripts')
	@include('js.feed')
@endpush