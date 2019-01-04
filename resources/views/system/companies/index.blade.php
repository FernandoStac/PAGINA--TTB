@extends('layouts.public')
@section('title','Inicio')

@section('content')

<div class="wrapper">
    <div class="page-header page-header-xs" data-parallax="true" style="background-image: url('{{ asset('assets/img/fabio-mangione.jpg') }}');">
        <div class="filter"></div>
    </div>              
</div>


<nav class="navbar navbar-expand-md bg-danger">
  <div class="container">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i> Empresas</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">
          @if($available==8)
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-building"></i> Alta empresa</a>
          </li>
          @elseif($available<=7 && $available>=1 && Auth::user()->role->id==1 && (Auth::user()->name=='root'))
            <li class="nav-item">
              <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal">{{$available}} <i class="fa fa-building"></i> Alta empresa</a>
            </li>
           @endif
        </ul>
      </div>
  </div>
</nav>

<br>
<br>
<br>

<div class="container">  
  <div class="row">
   @if(count($companies)==0)

    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">No tienen ninguna empresa dada de alta</h5>
        </div>
      </div>
      <br>
      <br>
      <br>
      <br>
    </div>

  @else
    @foreach($companies as $companie)
      <div class="col-sm-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fa fa-building"></i>  {{$companie->name}}</h5>
            <p class="card-text">{{$companie->name_short}}</p>
            <a href="{{url('system/companie/'.$companie->name_short.'/documents')}}" class="btn btn-primary">Ir a la empresa</a>
          </div>
        </div>
      </div>
    @endforeach
  @endif
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Nueva empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newCompanie" method="post" class="" action="{{url('/system/companie')}}">
            <div class="modal-body">

              
                {{csrf_field()}}
                <div class="form-group">
                  <label for="name">Nombre de la empresa</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la empresa" required="">
                </div>

                <div class="form-group">
                  <label for="name_shot">*Nombre corto</label>
                  <input type="text" class="form-control" id="name_short" name="name_short" placeholder="Nombre corto sin espacios" required="" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]*$" title="Nombre sin espacios ni caracteres especiales">
                </div>

                <div class="form-group">
                  <label for="email">Email donde se notificara que la empresa cargo un archivo</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required="" >
                </div>

            </div>
            <div class="modal-footer">
                <div class="left-side">
                    <button  class="btn btn-default btn-link"  id="btnNewCOmpanie">Guardar</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                    <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>



@include('includes.footer')
@endsection

@section('scripts')

<script> 


</script>


@endsection
