<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Sign In</title>
</head>
<body>
<h1 class="text-center mt-5">Sign In</h1>
<form action="{{route('user_login')}}" method="post" class="text-center">
    @if(Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    @if(Session::has('fail'))
        <div class="alert alert-danger">{{Session::get('fail')}}</div>
    @endif

    @csrf
    <div class="text-danger">
        <span>@error('email') {{$message}} @enderror</span>
        <br>
        <span>@error('password') {{$message}} @enderror</span>
    </div>
    <input type="email" class="mt-2" name="email" placeholder="E-mail" value="{{old('email')}}">
    <br>
    <input type="password" class="mt-2" name="password" placeholder="Password" value="{{old('password')}}">
    <br>
    <button type="submit" class="mt-5 btn btn-secondary">Sign In</button>
</form>
</body>
</html>
