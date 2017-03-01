@extends('auth::login-base')

@section('content')

<form action="/auth/reset" class="form-signin cmxform" method="POST">
    <h2 class="form-signin-heading">choose your new password</h2>
    <div class="login-wrap">
        <div class="user-login-info form-group">
             <input type="hidden" name="token" value="{{ $token }}">
            {!! $errors->first('email', '<label for="email" class="error">:message</label>') !!}
            {!! Form::text('email', null, ['class' => 'form-control'.($errors->has('email') ? ' error' : ''), 'placeholder' => 'Email']) !!}
            {!! $errors->first('password', '<label for="email" class="error">:message</label>') !!}
            {!! Form::password('password', ['class' => 'form-control'.($errors->has('password') ? ' error' : ''), 'placeholder' => 'New Password']) !!}
            {!! $errors->first('password_confirmation', '<label for="email" class="error">:message</label>') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control'.($errors->has('password_confirmation') ? ' error' : ''), 'placeholder' => 'Please Retype Password']) !!}
        </div>
        <span class="pull-right">
            <a href="/auth/login"> Back to login</a>
        </span>
        <br>
        <button class="btn btn-lg btn-login btn-block" type="submit">Reset Password</button>
        @if (Session::has('status'))
            <ul class="list-bare">
                <li>{!! Session::get('status') !!}</li>
            </ul>
        @endif
    </div>
</form>

@endsection