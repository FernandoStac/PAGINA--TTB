@extends('layouts.public')
@section('title','Login')

@section('content')


<div class="wrapper">
        <div class="page-header" style="background-image: url('../assets/img/login-image.jpg');">
            <div class="filter"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 ml-auto mr-auto">
                            <div class="card card-register">
                                <h3 class="title">Bienvenido</h3>
                                
                                 <form class="register-form" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                     @csrf
                                    <label for="email" >{{ __('E-Mail') }}</label>


                                    
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                   

                                   

                                    <label for="password" >{{ __('Password') }}</label>

                                    
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                   
                                        <div class="form-check">
                                            <label for="remember" class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                 {{ __('Recuerdame Me') }}
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                        

                               
                                  
                                            <button type="submit" class="btn btn-warning btn-block ">
                                                {{ __('Entrar') }}
                                            </button>

                                          <!--   <a class="btn btn-info btn-block " href="{{ route('register') }}">
                                                {{ __('Registrarse') }}
                                            </a> -->

                                            <a class="btn btn-link btn-block " href="{{ route('password.request') }}">
                                                {{ __('Olvide mi contraseña?') }}
                                            </a>
                                   
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="footer register-footer text-center">
                        <h6>&copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by JJAvier </h6>
                    </div>
                </div>
        </div>
    </div>


@endsection
