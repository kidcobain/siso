@extends('layouts.app')

@section('content')
<div class="container">
    <style>

    #app:before {
      content: "";
      position: fixed;
      left: 0;
      right: 0;
      z-index: -1;
      
      display: block;
      background-image: url(img/comercio_suministro.jpg);
       background-size: cover;
      
      /* width: 1200px; */
      min-height: 100%;
      
      -webkit-filter: blur(5px);
      -moz-filter: blur(5px);
      -o-filter: blur(5px);
      -ms-filter: blur(5px);
      filter: blur(3px);
    }

    #app {
      position: fixed;
      left: 0;
      right: 0;
      z-index: 0;
    }
   
    /* latin-ext */
    


    .logo >img {
        width: 320px;
        height: 100px;
        display: inline-block;
        text-align: center;
    }

    .logo {
        display: inline-block;
        text-align: center;
        /* vertical-align: middle; */
        overflow: hidden;
        margin-left: 200px;
        height: 175px;
        margin-top: 75px;
    }

    form.form-horizontal {
        margin-bottom: 50px;
    }

    .col-md-8.col-md-offset-2 {
        /* -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075); */
        /* box-shadow: inset 1px 1px 1px rgba(0, 0, 0, 0.095); */
        /* -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s; */
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
/*
    .logo >img {
        width: 500px;
        height: 350px;
        display: inline-block;
        margin-left: 100px;
*/

    /*
      body {
   
    background: url(img/comercio_suministro.jpg) 50% 50% no-repeat fixed;
    filter: blur(5px); 
    background-size: cover;
    }

    body:before{
        filter: blur(5px);
    }
    */
    </style>
                @if (session('exito'))
                    <div class="alert alert-success col-sm-offset-2 col-sm-8 mensaje">
                        {{ Session::get('exito') }}
                    </div>
                @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
               <!--  <div class="panel-heading">Inicio</div> -->
                <div class="panel-body">
                  <div class="logo"><img src="img/PDVSA-Logo.png" alt=""></div>
                  <!-- <div class="logo"><img src="img/logo.svg" alt=""></div> -->
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electronico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordar
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary"> 
                                    entrar
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Olvido Contraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
