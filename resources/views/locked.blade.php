<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirm Your Email</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/locked.css') }}">
</head>
<body>

    <div class="main">
        <div class="box">
            <div class="logo center">
                <img src="/logo-light.png" alt="Logo">
            </div>
            <h1 class="callout center">Enter Code:</h1>
            <h4 class="description center">Enter the 5-digit code from the confirmation email we sent to you.<br />Or you can click on the confirmation link to skip this process.</h4>
            <div class="enter-box">
                <div class="number-box" contenteditable></div>
                <div class="number-box" contenteditable></div>
                <div class="number-box" contenteditable></div>
                <div class="number-box" contenteditable></div>
                <div class="number-box" contenteditable></div>
            </div>
            <div class="error center @if($errors->isEmpty())hidden @endif">
                <h3>Wrong code!</h3>
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