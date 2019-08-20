@extends('layouts.app')

@section('content')
@include('layouts.admin-navbar')
<div class="container">
    <div class="row">
        <div class="login">
            <div class="login_box">
                <div class="head">Admin Login</div>
                <div class="body">
                <form class="form-horizontal" method="POST" action="{{ route('admin.login') }}">
                    {{ csrf_field() }}

                    <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <i class="fa fa-user"></i>
                        <input id="email" type="email" class="input-control" name="email" value="{{ old('email') }}" required autofocus>
                        <label>Username</label>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <i class="fa fa-lock"></i>
                        <input id="password" type="password" class="input-control" name="password" required>
                        <label>Password</label>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                    </div>
                    
                    <div class="login_btn text-center">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                    <div class="forgot">
                        <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

