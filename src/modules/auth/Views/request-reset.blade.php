@extends('auth::login-base')

@section('content')
    <form action="/auth/email" class="form-signin cmxform" method="POST">
        <h2 class="form-signin-heading">verify your email</h2>
        <div class="login-wrap">
            <div class="user-login-info form-group">
                {!! $errors->first('email', '<label for="email" class="error">:message</label>') !!}
                <input
                    class="form-control {{ $errors->has('email') ? ' error' : '' }}"
                    type="text"
                    placeholder="Email"
                    name="email"
                    value="{{ $errors->has('email') ?: '' }}"
                    {{ Session::has('status') ? 'disabled' : '' }}
                >
            </div>
                <span class="pull-right">
                    <a href="/auth/login"> Back to login</a>
                </span>
                <br>

            <button class="btn btn-lg btn-login btn-block" type="submit">Send reset link</button>
            @if (Session::has('status'))
                {!! Session::get('status') !!}
            @endif
        </div>
    </form>
@endsection