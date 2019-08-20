@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="container">
    <div class="row">
        <!-- <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4"> -->
            <div class="login">
                <div class="login_box">
                    <div class="head">Login</div>
                    <div class="body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <!-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> -->
                                <i class="fa fa-user"></i>
                            <!-- <div class="col-md-6"> -->
                                
                                <input id="email" type="email" class="input-control" name="email" value="{{ old('email') }}" required autofocus>
                                <label>Username</label>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            <!-- </div> -->
                        </div>

                        <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <!-- <label for="password" class="col-md-4 control-label">Password</label> -->
                            <i class="fa fa-lock"></i>
                            <!-- <div class="col-md-6"> -->
                                <input id="password" type="password" class="input-control" name="password" required>
                                <label>Password</label>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            <!-- </div> -->
                        </div>
                       
                        <div class="login_btn text-center">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                        <div class="forgot">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                            <a class="btn btn-link" href="{{ route('register') }}">
                                SignUp
                            </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </div>
</div>

@endsection

