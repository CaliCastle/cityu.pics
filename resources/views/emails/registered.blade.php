<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@lang('messages.email.confirm.title', ['code' => $code = $user->getConfirmationCode()])</title>
</head>
<body>
<h2>Hi, {{ $user->name }}</h2>
<p>@lang('messages.email.confirm.message', ['url' => $user->getConfirmationLink(), 'code' => $code])</p>
<p>@lang('messages.email.confirm.ignore')</p>
<footer>
    <b>Thanks, CityU Pics</b><br>
    <a href="{{ url('/') }}">{{ url('/') }}</a>
</footer>
</body>
</html>