@extends('layouts.auth')

@section('title', trans('auth.register'))

@section('sidebar')
    <div class="col-xs-12 col-sm-4 col-md-3 login-sidebar animated fadeInRightBig">

        <div class="login-container register-form animated fadeInRightBig">

            <h2><i class="fa fa-vcard-o"></i> @lang('messages.auth.register.heading'):</h2>

            <form action="{{ route('register') }}" method="POST">
                {{ csrf_field() }}
                <input type="checkbox" name="remember" checked hidden>
                <div class="group">
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label><i class="fa fa-at"></i><span class="span-input"> @lang('messages.auth.login.email')</span></label>
                </div>

                <div class="group">
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label><i class="fa fa-vcard"></i><span class="span-input"> @lang('messages.auth.register.name')</span></label>
                </div>

                <div class="group">
                    <input type="password" name="password" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label><i class="fa fa-key"></i><span class="span-input"> @lang('messages.auth.register.password')</span></label>
                </div>

                <div class="group">
                    <input type="password" name="password_confirmation" required>
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <label><i class="fa fa-key"></i><span class="span-input"> @lang('messages.auth.register.password-confirm')</span></label>
                </div>

                <button type="submit" class="btn btn-block login-button">
                    <span class="registering hidden"><span class="fa fa-spinner fa-spin fa-fw"></span> @lang('messages.auth.register.registering')...</span>
                    <span class="register">@lang('auth.register')</span>
                </button>

                @if(Route::has('login'))
                    <a class="other-link" href="{{ route('login') }}">
                        @lang('messages.auth.register.got-account')
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
    </div>
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
                btn.querySelector('.registering').className = 'registering';
                btn.querySelector('.register').className = 'register hidden';
            } else {
                ev.preventDefault();
            }
        });
    </script>
@endpush