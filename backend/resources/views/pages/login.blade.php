<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Animated Login Form | CodingNepal</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">
</head>
<body>
<div class="login-page">
    <div class="center">
        <h1>Login</h1>
        @if (count($errors) >0)
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger"> {{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="login" method="post">
            {{ csrf_field() }}
            <div class="txt_field">
                <input type="text" name="username" required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
</div>

</body>
</html>
