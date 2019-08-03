@extends('layouts.base')

@section('body')

<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">

        <header class="main-header">
            <a href="/" class="logo">
                <span class="logo-mini"><b>A</b>LT</span>
                <span class="logo-lg"><b>Admin</b>LTE</span>
            </a>

            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ url('images/user.jpg') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ url('images/user.jpg') }}" class="img-circle" alt="User Image">
                                    <p>
                                        {{ auth()->user()->name }}
                                        <small>Member since {{ auth()->user()->created_at->format('M\. Y') }}</small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('companies*') ? 'active' : '' }}">
                        <a href="{{ route('companies.index') }}">
                            <i class="fa fa-building"></i> <span>Companies</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('employees*') ? 'active' : '' }}">
                        <a href="{{ route('employees.index') }}">
                            <i class="fa fa-users"></i> <span>Employees</span>
                        </a>
                    </li>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>@yield('title')</h1>
            </section>

            <section class="content">

                @include('partials.flash-messages')

                @yield('content')

            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.13
            </div>
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
@endsection