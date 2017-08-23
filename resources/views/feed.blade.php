@extends('layouts.app')

@section('title', trans('messages.titles.feed'))

@section('content')
    <div class="feed-content">
        <div class="container">
            @include('layouts.feed-layout')
        </div>
    </div>
@endsection

@push('scripts')
    @include('js.feed')
@endpush