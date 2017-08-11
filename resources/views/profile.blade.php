@extends('layouts.app')

@section('title', trans('messages.titles.profile', ['user' => $user->name]))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}?v={{ config('app.version') }}">
    <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">
@endpush

@section('content')
<div class="profile-content">
    <div class="container">
        <div class="profile--section">
            <div class="profile--section__user">
                <div class="profile__user-avatar"{{ Auth::user() == $user ? ' data-upload title=' . trans('messages.profile.upload-avatar.title') : '' }}>
                    <img src="{{ Voyager::image($user->avatar) }}" alt="{{ $user->name }}" class="img-circle">
                </div>
                @if(Auth::user() == $user)
                <div class="avatar-editor animated fadeInUp hidden" id="avatar-cropper">
                    <div class="avatar-editor__actions">
                        <button class="avatar-editor__change">@lang('messages.profile.upload-avatar.change')</button>
                        <button class="avatar-editor__done">@lang('messages.profile.upload-avatar.done')</button>
                    </div>
                    <input class="hidden" type="file" accept="image/*" id="avatar-selector">
                    <img class="avatar-preview" src="{{ Voyager::image($user->avatar) }}" alt="@lang('messages.profile.upload-avatar.title')">
                </div>
                @endif
                <span class="profile__user-name{{ $user->isAdmin() ? ' admin' : ($user->isVerified() ? ' verified' : '') }}">{{ $user->name }}</span>
                <a href="mailto:{{ $user->email }}" class="profile__user-email">{{ $user->email }}</a>
            </div>
        </div>
        <div class="row">
            <h2 style="font-weight: 600;color: #d9d9d9">{{ trans_choice('messages.profile.posts-found', $posts->total(), ['total' => $posts->total()]) }}</h2>
        </div>
        @include('layouts.feed-layout')
    </div>
</div>
@stop

@push('scripts')
    <script src="{{ asset('js/cropper.min.js') }}"></script>
    <script>
        var reader = new FileReader();
        var $preview = $('#avatar-cropper > img')[0];
        var $cropper = $('#avatar-cropper');
        var $currentAvatar = $('.profile__user-avatar');
        var cropper;

        $(function () {
            $('.profile__user-avatar[data-upload]').click(function () {
                $('#avatar-selector').click();
            });
            $('.avatar-editor__change').click(function () {
                $('#avatar-selector').click();
            });
            $('.avatar-editor__done').click(function () {
                doneCrop();
            });
            $('#avatar-selector').change(function () {
                var $this = this;
                reader.readAsDataURL($this.files[0]);
            });
        });

        reader.addEventListener("load", function () {
            $preview.src = reader.result;
            openAvatarCropper();
            setupCropper();
        });

        function setupCropper() {
            if (!cropper) {
                cropper = new Cropper($preview, {
                    aspectRatio: 1,
                    viewMode: 1
                });
            } else {
                cropper.replace($preview.src);
            }
        }
        
        function openAvatarCropper() {
            if ($cropper.hasClass('hidden')) {
                $cropper.removeClass('hidden');
                $currentAvatar.hide();
            }
        }

        function closeAvatarCropper() {
            $cropper.addClass('fadeOutDown');
            setTimeout(function () {
                $cropper.toggleClass('hidden');
                $cropper.removeClass('fadeOutDown');
                $currentAvatar.show();
            }, 990);
        }

        function doneCrop() {
            var data = cropper.getData();
            closeAvatarCropper();

            var xhr = new XMLHttpRequest();
            var formData = new FormData();
            var file = document.querySelector('#avatar-selector').files[0];

            formData.append('image', file, file.name);
            formData.append('x', data.x);
            formData.append('y', data.y);
            formData.append('width', data.width);
            formData.append('height', data.height);

            xhr.open('POST', '{{ route('upload-avatar') }}', true);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Cache-control', 'no-cache');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(formData);

            xhr.onload = function () {
                if (xhr.status == 200) {
                    $($currentAvatar).children('img')[0].src = xhr.responseText;
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);
                } else {
                    displayErrorMessage();
                }
            }
        }
    </script>
    @include('js.feed')
@endpush