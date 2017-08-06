<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="none">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>Confirm Your Email</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/locked.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">

    <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
    <link rel="icon" type="image/x-icon" href="/logo.png">
    <link rel="shortcut icon" type="image/x-icon" href="/logo.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

    <div class="main">
        <div class="box animated fadeInUp">
            <div class="logo center">
                <img src="/logo-light.png" alt="Logo">
            </div>
            <h1 class="callout center">Enter Code:</h1>
            <h4 class="description center">Enter the 5-digit code from the confirmation email we sent to you.<br />Or you can click on the confirmation link to skip this process.</h4>
            <div class="enter-box">
                @for($i = 1; $i < 6; $i++)
                <div class="number-box animated fadeInUp" contenteditable style="animation-delay: .{{ ($i * 12) + 5 }}s"></div>
                @endfor
            </div>
            <div class="error center @if($errors->isEmpty())hidden @endif animated bounceIn">
                <h3>Wrong code!</h3>
            </div>
            <div class="resend center">
                <button class="resend-button animated fadeIn">Resend the code</button>
                <span class="animated fadeInLeft hidden">Code sent!</span>
            </div>
        </div>
    </div>

    <form action="{{ route('locked') }}" class="hidden" method="POST">
        {{ csrf_field() }}
        <input type="number" name="code">
    </form>

    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="{{ asset('js/locked.js') }}"></script>
</body>
</html>