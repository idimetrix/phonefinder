<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
<div class="container">
    <div class="col-sm-6 col-md-4 col-md-offset-4">
        <h2 class="form-signin-heading">Register</h2>
        {{ Form::open(['action' => 'Auth\RegisterController@register', 'method' => 'POST', 'class' => 'form-signin']) }}
        {{ Form::text('name', '', ['class' => 'form-control','type'=>'text', 'placeholder' => trans('login.name'), 'required']) }}
        {{ Form::text('email', '', ['class' => 'form-control','type'=>'email', 'placeholder' => trans('login.email'), 'required']) }}
        {{ Form::password('password', ['class' => 'form-control','type'=>'password', 'placeholder' => trans('login.password'), 'required']) }}
        {{ Form::password('password_confirmation', ['class' => 'form-control','type'=>'password', 'placeholder' => trans('login.repeat_pass'), 'required']) }}
        {{ Form::submit('Submit', ['class' => 'btn btn-lg btn-primary btn-block btn-signin']) }}
        {{ Form::close() }}
        <a class="btn btn-link" href="{{ URL::to('/login')}}">Login</a>
    </div>
</div>
</body>
</html>