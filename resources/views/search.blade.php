@extends('layouts.app')

@section('title', trans('messages.titles.search', compact('query')))

@section('content')
	<div class="search-content">
		<div class="container">
			<div class="row">
				<h2 class="panel-heading lime-text">Related Tags:</h2>
				@forelse($tags as $i => $tag)
					<a href="{{ $tag->link() }}" class="chip no-decoration animated fadeIn" style="animation-delay: {{ ($i * 0.12) + 0.03 }}s">
						#{{ $tag->name }} ({{ $tag->relatedPostsCount() }})
					</a>
				@empty
				@endforelse
			</div>
			<div class="row">
				<h2 class="panel-heading cyan-text">Related Users:</h2>
				<ul class="collection">
					@forelse($users as $i => $user)
					<li class="collection-item avatar animated fadeIn waves-effect" style="animation-delay: {{ ($i * 0.12) + 0.03 }}s">
						<a href="{{ $user->profileLink() }}" class="no-decoration">
							<img src="{{ $user->avatarUrl }}" alt="{{ $user->name }}" class="circle">
							<span class="title white-text">{{ $user->name }}</span>
							<p class="teal-text">{!! trans_choice('messages.profile.followers', $user->followers, ['count' => $user->followers]) !!}</p>
							<p class="green-text">{{ $user->posts()->count() }} posts</p>
						</a>
					</li>
					@empty
					@endforelse
				</ul>
			</div>
			<div class="row">
				<h2 class="panel-heading orange-text">Related Posts:</h2>
				@include('layouts.feed-layout')
			</div>
		</div>
	</div>
@stop

@push('scripts')
	@include('js.feed')
@endpush