@extends('layouts.app')

@section('title', trans_choice('messages.titles.tag', $posts->count(), ['tag' => $tag->name]))

@section('content')
	<div class="tag-container">
		<div class="container">
			<div class="row">
				<h2 class="panel-heading white-text center"><i class="fa fa-tags"></i>&nbsp;{{ $posts->count() }}&nbsp;{{ trans_choice('messages.titles.tag', $posts->count(), ['tag' => $tag->name]) }}</h2>
			</div>
			<div class="row">
				<div class="feed-content">
					@include('layouts.feed-layout')
				</div>
			</div>
		</div>
	</div>
@stop

@push('scripts')
	@include('js.feed')
@endpush