<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Registered!</title>
</head>
<body>
<h2>Hi, {{ $user->name }}</h2>
<p>Thanks for registering at our website, <a href="{{ $user->getConfirmationLink() }}">click to confirm your account</a> or enter the confirmation code {{ $user->getConfirmationCode() }}</p>
<p>If you didn't register an account at our website, then ignore this e-mail.</p>
<footer>
    <b>Thanks, CityU Pics</b>
    <a href="{{ url('/') }}">CityU Pics</a>
</footer>
</body>
</html>