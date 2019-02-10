@extends('layouts.public')
@section('title','Página principal')

@section('content')
    <div class="wrapper">

        <div class="page-header section-dark" style="background-image: url('https://source.unsplash.com/collection/540518/')">
            <div class="filter"></div>
            <div class="content-center">
                <div class="container">
                    <div class="title-brand">
                        <h1 class="presentation-title"> InvoicePDF</h1>
                        <div class="fog-low">
                            <img src="assets/img/fog-low.png" alt="">
                        </div>
                        <div class="fog-low right">
                            <img src="assets/img/fog-low.png" alt="">
                        </div>
                    </div>

                    <h2 class="presentation-subtitle text-center">{{date('d-m-Y')}}</h2>
                </div>
            </div>
            <div class="moving-clouds" style="background-image: url('{{ asset('assets/img/clouds.png') }}'); ">

            </div>
       
        </div>
        <div class="main">
       
       
            <div class="section section-dark section-nucleo-icons">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h2 class="title">¡Administración de documentos!</h2><br/>
                            <p class="description">
                                <span>¡Cargue documentos!</span>
                            </p><p class="description">
                                <span>¡Verifique el estatus!</span>
                            </p><p class="description">
                                <span>¡Valide sus documentos en tres pasos!</span>
                            </p>
                         
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="icons-container">
                                <i class="nc-icon nc-time-alarm"></i>
                                <i class="nc-icon nc-atom"></i>
                                <i class="nc-icon nc-camera-compact"></i>
                                <i class="nc-icon nc-watch-time"></i>
                                <i class="nc-icon nc-key-25"></i>
                                <i class="nc-icon nc-diamond"></i>
                                <i class="nc-icon nc-user-run"></i>
                                <i class="nc-icon nc-layout-11"></i>
                                <i class="nc-icon nc-badge"></i>
                                <i class="nc-icon nc-bulb-63"></i>
                                <i class="nc-icon nc-favourite-28"></i>
                                <i class="nc-icon nc-planet"></i>
                                <i class="nc-icon nc-tie-bow"></i>
                                <i class="nc-icon nc-zoom-split"></i>
                                <i class="nc-icon nc-cloud-download-93"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">

                <div class="credits ml-auto">
                    <span class="copyright">
                        © <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by JJ
                    </span>
                </div>
            </div>
        </div>
    </footer>



@endsection





