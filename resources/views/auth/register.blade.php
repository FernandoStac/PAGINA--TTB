




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
                                <h3 class="title">Registro</h3>




                                <form class="register-form" method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                                    @csrf

                                    
                                        <label for="name" >{{ __('Nombre') }}</label>

                                      
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                       
                   
                              
                                        <label for="email" >{{ __('E-Mail') }}</label>

                                    
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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
                                       

                                
                                        <label for="password-confirm" >{{ __('Confirmar Password') }}</label>

                                     
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        
                             
                                            <button type="submit" class="btn btn-warning btn-block">
                                                {{ __('Registrarse') }}
                                            </button>
                                     
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
