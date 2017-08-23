@extends('layouts.app')

@section('title', trans('messages.app.404'))

@section('content')
	<div class="fof-container">
		<div class="container text-center">
			<div class="fof">
				<div class="fof-img animated bounceInDown"></div>
				<h1 class="animated bounceIn">@lang('messages.app.404')</h1>
				<img alt="😥" class="emojioneemoji animated fadeIn" src="https://cdnjs.cloudflare.com/ajax/libs/emojione/2.2.7/assets/png/1f625.png">
			</div>
		</div>
	</div>
@stop