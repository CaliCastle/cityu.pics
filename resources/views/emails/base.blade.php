<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>

<div style="width:100%;max-width:720px;text-align: left;margin: 0 auto;padding-bottom: 20px;box-shadow:0 6px 18px rgba(0,0,0,0.15);border-radius: 10px;overflow: hidden">
    <div class="email-title">
        <h1 style="color:#fff;background: #0D3B62;line-height:70px;font-size:24px;font-weight:normal;padding-left:40px;margin:0">
            @yield('title')
        </h1>
        <div class="email-text"
             style="background:rgba(255,255,255,0.9);padding:20px 32px 40px;border-bottom-left-radius:10px;border-bottom-right-radius:10px">
            <span style="padding-bottom:10px">Hi, {{ $user->name }}</span>

            @yield('content')

        </div>
    </div>
    <p style="color: #6e6e6e;font-size:13px;line-height:24px;text-align:right;padding:0 32px">
        @lang('messages.email.base.sent-from')
        <a href="{{ url('/') }}" style="color:#444;text-decoration:none">CityU Pics</a>
    </p>
</div>


</body>
</html>