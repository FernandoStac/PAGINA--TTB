<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="{{ asset('core/styles/accents/info.1.1.0.css') }}">
</head>
<body class="antialiased font-sans" >
  
  <div class="md:flex min-h-screen" >
    
    <div class="w-full md:w-1/2 bg-white flex items-center justify-center"  >
    
    <div class="col-md-10">
      
          <div class="form-group" >   
            <br>
            <img src="{{ asset('assets/img/LogoEmpresa.jpg ') }}" class="img-fluid" alt="logoprincipal">
            <h2>Login</h2>
            
            <br>
           
           
            <div class="h-1 bg-info" style="background-color:#f7765f !important"></div>
            
        
          </div>

        <form class="register-form" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
          @csrf
          <div class="form-group">
            <label for="email" >{{ __('E-Mail') }}</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
                                   
          <div class="form-group">
            <label for="password" >{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          
          <div class="form-group">
            <div class="custom-control custom-checkbox mb-1">
                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">{{ __('Recuérdame') }}</label>
            </div>                         
          </div>
                                                       
          <button type="submit" class="btn btn-info btn-block"  style="background:#f7765f;    border-color: #f7765f">
            {{ __('Entrar') }}
          </button>

          <!--   <a class="btn btn-info btn-block " href="{{ route('register') }}">
                {{ __('Registrarse') }}
            </a> -->

          <a class="btn btn-link btn-block " href="{{ route('password.request') }}">
              {{ __('Olvide mi contraseña?') }}
          </a>

          <a class="btn btn-link btn-block " href="{{ url('/') }}">
              {{ __('Inicio') }}
          </a>
        </form>
      </div>
    </div>
    

    <div class="relative pb-50 md:flex md:pb-full md:min-h-screen w-full md:w-full" style="background-image: url('{{ asset('assets/img/Cabo1.jpg') }}'); ">
        <div >
        </div>
    </div>
  </div>
</body>
</html>
            