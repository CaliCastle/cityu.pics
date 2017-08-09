@extends('layouts.auth')

@section('title', trans('auth.login'))

@section('sidebar')
    <div class="col-xs-12 col-sm-4 col-md-3 login-sidebar animated fadeInRightBig">

        <div class="login-container animated fadeInRightBig">

            <h2><i class="fa fa-vcard-o"></i> @lang('messages.auth.login.heading'):</h2>

            <form action="{{ route('login') }}" method="POST">
                {{ csrf_field() }}
                <input type="checkbox" name="remember" checked hidden>
                <div class="group">
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label><i class="fa fa-user-circle"></i><span class="span-input"> @lang('messages.auth.login.email')</span></label>
                </div>

                <div class="group">
                    <input type="password" name="password" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label><i class="fa fa-key"></i><span class="span-input"> @lang('auth.input.password')</span></label>
                </div>

                <button type="submit" class="btn btn-block login-button">
                    <span class="signingin hidden"><span class="fa fa-spinner fa-spin fa-fw"></span> @lang('messages.auth.login.logging')...</span>
                    <span class="signin">@lang('auth.login')</span>
                </button>

                @if(Route::has('register'))
                    <a class="other-link" href="{{ route('register') }}">
                        @lang('messages.auth.login.first-time')
                    </a>
                @endif
            </form>

            @if(!$errors->isEmpty())
                <div class="alert alert-black animated bounceInUp">
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div> <!-- .login-container -->
@stop

@push('styles')
    <link rel="stylesheet" href="{{ voyager_asset('css/login.css') }}">
    <style>
        body {
            background-image:url('{{ Voyager::image( Voyager::setting("admin_bg_image"), config('voyager.assets_path') . "/images/bg.jpg" ) }}');
            background-color: {{ Voyager::setting("admin_bg_color", "#FFFFFF" ) }};
        }
        .login-sidebar:after {
            background: linear-gradient(-135deg, {{config('voyager.login.gradient_a','#ffffff')}}, {{config('voyager.login.gradient_b','#ffffff')}});
            background: -webkit-linear-gradient(-135deg, {{config('voyager.login.gradient_a','#ffffff')}}, {{config('voyager.login.gradient_b','#ffffff')}});
        }
        .login-button, .bar:before, .bar:after{
            background:{{ config('voyager.primary_color','#22A7F0') }};
        }

    </style>
@endpush

@push('meta')
    <meta name="robots" content="none" />
@endpush

@push('scripts')
    <script>
        var btn = document.querySelector('button[type="submit"]');
        var form = document.forms[0];
        btn.addEventListener('click', function(ev){
            if (form.checkValidity()) {
                btn.querySelector('.signingin').className = 'signingin';
                btn.querySelector('.signin').className = 'signin hidden';
            } else {
                ev.preventDefault();
            }
        });
    </script>
@endpush