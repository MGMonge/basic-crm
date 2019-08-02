@extends('layouts.base')

@section('body')

    <body class="hold-transition login-page">
    <div class="login-box">

        <div class="login-logo">
            <a href="#"><b>Admin</b>LTE</a>
        </div>

        @yield('content')
    </div>
    </body>
@endsection