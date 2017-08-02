<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Registered!</title>
</head>
<body>
<h2>Hi, {{ $user->name }}</h2>
<p>Thanks for registering at our website, <a href="{{ $user->getConfirmationLink() }}">click to confirm your account</a></p>
</body>
</html>