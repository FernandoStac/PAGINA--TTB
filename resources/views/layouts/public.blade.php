<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/paper-kit.css?v=2.1.0') }}" rel="stylesheet"/>

    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,300,700' rel='stylesheet' type='text/css'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/sweetalert/sweetalert2.css') }}" rel="stylesheet" />

    @yield('css')
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="fix_bar"></div>

    <nav class="navbar navbar-expand-md fixed-top bg-dark">
            <div class="container-fluid">
                <div class="navbar-translate">
                <button class="navbar-toggler navbar-toggler-right navbar-burger" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar"></span>
                    <span class="navbar-toggler-bar"></span>
                    <span class="navbar-toggler-bar"></span>
                </button>
                <a class="navbar-brand" href="{{('/')}}">I-PDF</a>
                <a class="navbar-brand"  href="{{asset('assets/img/Manual proveedores.pdf')}}"» target=»_blank» ></i>MANUAL PROVEEDOR</a>
                <a class="navbar-brand"  href="{{asset('assets/img/Manual interno.pdf')}}"» target=»_blank» ></i>MANUAL USUARIO</a>
            </div>
                <div class="collapse navbar-collapse" id="navbarToggler">
                    

                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                     @else
                        @foreach ($menus as $key => $item)
                            @if ($item['parent'] != 0)
                                @break
                            @endif
                            @include('partials.menu-item', ['item' => $item])
                        @endforeach


                         <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton" href="#pk" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                                <ul class="dropdown-menu dropdown-menu-right dropdown-danger">
                         
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                   
                              
                                </ul>
                            </li>


                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                        @endguest
                    </ul>

                  
                </div>
            </div>
        </nav>

    @yield('content')
</body>

<!-- Core JS Files -->
<script src="{{ asset('assets/js/jquery-3.2.1.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-ui-1.12.1.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/popper.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!-- Switches -->
<script src="{{ asset('assets/js/bootstrap-switch.min.js') }}"></script>

<!--  Plugins for Slider -->
<script src="{{ asset('assets/js/nouislider.js') }}"></script>

<!--  Plugins for DateTimePicker -->
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

<!--  Paper Kit Initialization and functons -->
<script src="{{ asset('assets/js/paper-kit.js?v=2.1.0') }}"></script>
<script src="{{ asset('assets/sweetalert/sweetalert2.min.js') }}"></script>

  @yield('scripts')
</html>
