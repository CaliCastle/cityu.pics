@extends('layouts.app')

@section('title', trans('messages.titles.liked'))

@section('content')
	<div class="liked-content">
		<div class="container">
			<div class="row">
				<h2 class="panel-heading white-text center"><i class="fa fa-heart"></i> @lang('messages.titles.liked')</h2>
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