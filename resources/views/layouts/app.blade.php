<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css')
</head>
<body style="padding-top: 70px;">
<div id="app">
    @if(\Auth::check())
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Reach Local Report API</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <!-- <li><a href="/dashboard"><span class="glyphicon glyphicon-dashboard"></span> &nbsp;Dashboard</a></li> -->
                        <li><a href="/users"><span class="glyphicon glyphicon-user"></span> &nbsp;Users</a></li>
                        <li><a href="/docs" ><span class="glyphicon glyphicon-book"></span> &nbsp;Documentation</a></li>
                        <li><a href="/idexcel" ><span class="glyphicon glyphicon-file"></span> &nbsp;Excel ID</a></li>
                        <li><a href="/logs" target="_blank"><span class="glyphicon glyphicon-fire"></span> &nbsp;Logs</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{ route('auth_post_logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
    @endif

    <div class="container">
        @yield('content')
    </div>

</div>

<script src="{{ asset('js/vendor.js') }}"></script>

@yield('js')
</body>
</html>
