<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Password Email</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>Your random password is: {{ $password }}</p>
    <p>Please keep this password secure and change it after logging in.</p>
    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
