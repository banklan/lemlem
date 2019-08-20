@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="container">
    <div class="row">
        <div class="register">
            <div class="register_box">
                <div class="head"> Register </div>
                <div class="body">
                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input id="name" type="text" class="input-control" name="name" value="{{ old('name') }}" required autofocus>
                            <label>Fullnames</label>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="input-control" name="email" value="{{ old('email') }}" required>
                            <label>Email</label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <textarea class="text-control" name="address" required rows="3"></textarea>
                            <label>Address</label>
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <input id="phone" type="text" class="input-control" name="phone" value="{{ old('phone') }}" required>
                            <label>Phone No</label>
                            
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="input-group">
                            <input id="alt_phone" type="text" class="input-control" name="alt_phone" value="{{ old('alt_phone') }}">
                            <label>Alternate Phone No</label>
                            
                            @if ($errors->has('alt_phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('alt_phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="input-control" name="password" required>
                            <label>Password</label>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="input-group">
                            <input id="password-confirm" type="password" class="input-control" name="password_confirmation" required>
                            <label>Confirm Password</label>
                        </div> 

                        <div class="reg_btn text-center">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
