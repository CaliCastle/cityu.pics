@extends('layouts.app')

@section('title', trans('messages.titles.profile', ['user' => $user->name]))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">
@endpush

@section('content')
<div class="profile-content feed-content">
    <div class="container">
        <div class="profile--section">
            <div class="profile--section__user">
                <div class="profile__user-avatar"{{ Auth::id() == $user->id ? ' data-upload title=' . trans('messages.profile.upload-avatar.title') : '' }}>
                    @if(Auth::id() == $user->id)
	                <img :src="User.avatarUrl" :alt="User.name" class="img-circle">
	                @else
	                <img src="{{ $user->avatarUrl }}" alt="{{ $user->name }}" class="img-circle">
					@endif
                </div>
                @if(Auth::id() == $user->id)
                <div class="avatar-editor animated fadeInUp hidden" id="avatar-cropper">
                    <div class="avatar-editor__actions">
                        <button class="avatar-editor__change">@lang('messages.profile.upload-avatar.change')</button>
                        <button class="avatar-editor__done">@lang('messages.profile.upload-avatar.done')</button>
                    </div>
                    <input class="hidden" type="file" accept="image/*" id="avatar-selector">
                    <img class="avatar-preview" src="{{ Voyager::image($user->avatar) }}" alt="@lang('messages.profile.upload-avatar.title')">
                </div>
                @endif
                <span class="profile__user-name{{ $user->isAdmin() ? ' admin' : ($user->isVerified() ? ' verified' : '') }}" v-cloak>
	                @if(Auth::id() == $user->id)
		                @{{ User.name }}
	                @else
		                {{ $user->name }}
	                @endif
                </span>
                @if($user->display_email)
	            <a href="mailto:{{ $user->email }}" class="profile__user-email" v-cloak>@if(Auth::id() == $user->id)@{{ User.email }}@else{{ $user->email }}@endif</a>
	            @endif
	            @if($user->description)
					<p class="description">{{ $user->description }}</p>
				@endif
                <div class="profile__user-follow-wrapper">
	                <div class="profile__user-follow">
		                <span class="profile--following">@lang('messages.profile.followings', ['count' => $user->followings])</span>
		                <span class="profile--follower">{!! trans_choice('messages.profile.followers', $user->followers, ['count' => $user->followers]) !!}</span>
	                </div>
	                @if(Auth::id() != $user->id)
	                <div class="profile__follow-action">
		                <button class="profile__follow-button{{ Auth::user()->followed($user) ? (Auth::user()->followedEachOther($user) ? ' followed-back' : ' followed') : '' }}" followed="@lang('messages.profile.follow-state.followed')" followed-back="@lang('messages.profile.follow-state.followed-back')" unfollowed="@lang('messages.profile.follow-state.unfollowed')">
			                @if(Auth::user()->followedEachOther($user))
				                <i class="fa fa-exchange"></i>&nbsp;
				                <span>@lang('messages.profile.follow-state.followed-back')</span>
							@elseif(Auth::user()->followed($user))
				                <i class="fa fa-check"></i>&nbsp;
				                <span>@lang('messages.profile.follow-state.followed')</span>
			                @else
				                <i class="fa fa-plus"></i>&nbsp;
				                <span>@lang('messages.profile.follow-state.unfollowed')</span>
			                @endif
		                </button>
	                </div>
					@endif
                </div>
            </div>
        </div>
        <div class="feed__heading">
            <h2 style="font-weight: 600;color: #d9d9d9">{{ trans_choice('messages.profile.posts-found', $posts->total(), ['total' => $posts->total()]) }}</h2>
        </div>
        @include('layouts.feed-layout')
    </div>
</div>
@stop

@push('scripts')
    <script src="{{ asset('js/cropper.min.js') }}"></script>
    <script>
        var reader = new FileReader(),
	        $preview = $('#avatar-cropper > img')[0],
	        $cropper = $('#avatar-cropper'),
	        $currentAvatar = $('.profile__user-avatar'),
	        cropper,
            following = false;

        // Once ready, set up avatar cropper.
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

            // Follow button.
	        $('.profile__follow-button').on('click', function () {
		        if (following)
		            return false;

		        var $followButton = this;

		        following = true;
		        $followButton.style.opacity = 0.5;
		        // Send ajax request.
		        $.ajax({
			        url: '',
			        method: 'PUT',
			        data: {_token: Laravel.csrfToken},
			        success: function (s) {
			            // Animate button.
			            followButtonClicked($followButton);

			            // Clear class names.
			            $followButton.className = 'profile__follow-button';
			            // Switch to appropriate class and count.
						switch (s.state) {
							case 'both':
							    $followButton.classList.add('followed-back');
							    $followButton.querySelector('i.fa').className = 'fa fa-exchange';
							    $followButton.querySelector('span').innerText = $followButton.getAttribute('followed-back');
								break;
							case 'followed':
							    $followButton.classList.add('followed');
                                $followButton.querySelector('i.fa').className = 'fa fa-check';
                                $followButton.querySelector('span').innerText = $followButton.getAttribute('followed');
                                break;
							default:
                                $followButton.querySelector('i.fa').className = 'fa fa-plus';
                                $followButton.querySelector('span').innerText = $followButton.getAttribute('unfollowed');
                        }
                        $followButton.parentNode.previousElementSibling.querySelector('.profile--follower span').innerText = Number(s.followers);
                    },
			        error: function () {
				        displayErrorMessage();
                    },
			        complete: function () {
				        following = false;
                        $followButton.style.opacity = 1;
                    }
		        });
            });
        });

        function followButtonClicked($button) {

        }

        // Listens for input change.
        reader.addEventListener("load", function () {
            $preview.src = reader.result;
            openAvatarCropper();
            setupCropper();
        });

        // Setup cropper.
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

        // Opens up avatar cropper.
        function openAvatarCropper() {
            if ($cropper.hasClass('hidden')) {
                $cropper.removeClass('hidden');
                $currentAvatar.hide();
            }
        }

        // Close avatar cropper.
        function closeAvatarCropper() {
            $cropper.addClass('fadeOutDown');
            setTimeout(function () {
                $cropper.toggleClass('hidden');
                $cropper.removeClass('fadeOutDown');
                $currentAvatar.show();
            }, 990);
        }

        // Done cropping.
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
                    $vm.User.avatarUrl = xhr.responseText;
                } else {
                    displayErrorMessage();
                }
            }
        }
    </script>
    @include('js.feed')
@endpush