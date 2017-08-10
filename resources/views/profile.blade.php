@extends('layouts.app')

@section('title', trans('messages.titles.profile', ['user' => $user->name]))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}?v={{ config('app.version') }}">
@endpush

@section('content')
<div class="profile-content">
    <div class="container">
        <div class="profile--section">
            <div class="profile--section__user">
                <div class="profile__user-avatar">
                    <img src="{{ Voyager::image($user->avatar) }}" alt="{{ $user->name }}" class="img-circle">
                </div>
                <span class="profile__user-name">{{ $user->name }}</span>
            </div>
        </div>
        @include('layouts.feed-layout')
    </div>
</div>
@stop

@push('scripts')
    @include('js.feed')
@endpush