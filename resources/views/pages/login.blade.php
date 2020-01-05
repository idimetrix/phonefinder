<!doctype html>
<html>
<head>
    <title>{{trans('pages.title_site')}}</title>
    @include('includes.head')
</head>
<body>
<div class="container">

    <div class="col-sm-6 col-md-4 col-md-offset-4">
        <h2 class="form-signin-heading">Please sign in</h2>
        {{ Form::open(['action' => 'Auth\LoginController@login', 'method' => 'POST', 'class' => 'form-signin']) }}
        {{ Form::text('email', '', ['class' => 'form-control','type'=>'email', 'placeholder' => trans('login.email'), 'required','autofocus']) }}
        {{ Form::password('password', ['class' => 'form-control','type'=>'password', 'placeholder' => trans('login.password'), 'required']) }}
        <div class="form-group" id="checkbox">
            {{ Form::checkbox( 'remember_me', '', TRUE) }} Remember me
        </div>
        {{ Form::submit(trans('login.signin'), ['class' => 'btn btn-lg btn-primary btn-block']) }}
        {{ Form::close() }}
        {{--<a class="btn btn-link" href="{{ URL::to('/register')}}">Register</a>--}}
    </div>
</div>
</body>
</html>