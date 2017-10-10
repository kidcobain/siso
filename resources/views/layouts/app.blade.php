<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name','Sisor') }}</title>

    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles 
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <link href="//www.fuelcdn.com/fuelux/3.13.0/css/fuelux.min.css" rel="stylesheet">
    -->
    <style>
        .panel-default>.panel-heading {
            color: #333;
            background-color: #fff;
            border-color: #d3e0e9;
            background-image: -webkit-gradient(linear,left top, left bottom,from(#fefefe), color-stop(0.5,#f0f0f0), color-stop(0.51, #e6e6e6));
        }
        .navbar-default {
            background-color: #fff;
            border-color: #d3e0e9;
            background: #3db2e1;
            background: -o-linear-gradient(top, #69c4e8, #21a1d4);
            background: -ms-linear-gradient(top, #69c4e8, #21a1d4);
            background: -webkit-linear-gradient(top, #69c4e8, #21a1d4);
            background: -moz-linear-gradient(top, #69c4e8, #21a1d4);
            background: linear-gradient(to bottom, #69c4e8, #21a1d4);
            box-shadow: inset 0 -3px 0 #1f97c7, inset 0 -3px 3px #1f9acc, inset 0 2px 2px #9ad7ef, inset 1px 0 2px #22a4d9, inset -1px 0 2px #22a4d9, 0 1px 1px rgba(0, 0, 0, 0.1), 0 2px 2px rgba(0, 0, 0, 0.06), 0 3px 3px rgba(0, 0, 0, 0.17), 2px 1px 2px rgba(0, 0, 0, 0.05), -2px 1px 2px rgba(0, 0, 0, 0.05);
        }
        .navbar-default .navbar-nav>li>a, .navbar-default .navbar-text {
            color: #fefefe;
            font-weight: bold;
        }

        .logoheader>img {
            width: 110px;
            /* height: 30px; */
            display: inline-block;
        }

        .logoheader {
            display: inline-block;
            margin-left: -10px;
            margin-top: -20px;
        }
        a.navbar-brand {
            color: #fefefe !important;
            font-weight: bold;
            text-shadow: 2px 2px 1px rgb(66, 177, 221);
            color: #ffffff;
            font-size: 23px;
        }

        .panel.panel-default {
            margin-top: 50px;
        }
    </style>

</head>
<body class="fuelux">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/tabla') }}">
                        <div class="logoheader"><img src="img/PDVSA-Logo.png" alt=""></div>
                        {{-- <img src="img/logo.svg"> --}}
                        {{ config('app.name', 'Sisor') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Iniciar sesion</a></li>
                            <li><a href="{{ route('register') }}">Registrarse</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
      <!-- 
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
        Include all compiled plugins (below), or include individual files as needed 
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <script src="//www.fuelcdn.com/fuelux/3.13.0/js/fuelux.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    -->

</body>
</html>
