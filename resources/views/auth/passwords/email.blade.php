@extends('layouts.auth')

@section('content')

    <div class="login-box-body">
        <p class="login-box-msg">{{ __('Reset Password') }}</p>

        @include('partials.flash-message')

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="form-group has-feedback @error('email') has-error @enderror">
                <input id="email" type="text" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @error('email')
                    <span class="help-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group has-feedback">
                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Send Password Reset Link') }}</button>
            </div>
        </form>
    </div>

@endsection
