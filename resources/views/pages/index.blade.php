@extends('layouts.app')

@section('title', $title)

@section('content')
	<div class="page-container">
		<div class="container">
			<article class="Article">
				{!! $content !!}
			</article>
		</div>
	</div>
@stop