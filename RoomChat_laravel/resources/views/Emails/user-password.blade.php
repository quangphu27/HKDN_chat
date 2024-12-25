<!DOCTYPE html>
<html lang="en">

<head>
    @include('header')
</head>

<body>
<h2>Hello {{ $user->name }}!</h2>

<p>Your account has been created successfully.</p>
<p>Your password is: <strong>{{ $password }}</strong></p>

<p>Please change your password after logging in.</p>
@include('footer')

</body>

</html> 