@extends('auth::login-base')

@section('content')
    {!! Form::open(['url' => URL::to('/auth/login', [], true), 'class' => 'form-signin cmxform']) !!}
        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">

            <div class="user-login-info form-group">
                {!! $errors->first('email', '<label for="email" class="error">:message</label>') !!}
                {!! Form::text('email', null, ['class' => 'form-control'.($errors->has('email') ? ' error' : ''), 'placeholder' => 'Email']) !!}
                {!! $errors->first('password', '<label for="password" class="error">:message</label>') !!}
                {!! Form::password('password', ['class' => 'form-control'.($errors->has('password') ? ' error' : ''), 'placeholder' => 'Password']) !!}
            </div>
            <label class="checkbox">
                <input type="checkbox" name="remember"> Remember me
                <span class="pull-right">
                    <a href="/auth/reset"> Forgot Password?</a>
                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

        </div>
    </form>
@endsection