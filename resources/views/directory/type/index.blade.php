@extends('layouts.public')
@section('title','Inicio')

@section('css')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
@endsection

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
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i>Tipos acceso</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-building"></i>Nuevo acceso</a>
          </li>
 
        </ul>
      </div>
  </div>
</nav>
<br>
<br>
<br>





<div class="container">  
  <div class="row">
    <div class="col-md-12">
        <table id="usersTable" class="display table">
          <td>
            <thead class="thead-dark">
              <tr>
                  <th >Nombre de usuario</th>
                  <th>Empresa</th>
                  <th>Rol</th>
                  <th>Email</th>
                  <th>Acciones</th>
              </tr>
          </thead>
          </td>

        </table>
        <br>
        <br>
    </div>
  </div>
</div>






<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="updateUser" method="post" class="">
        <div class="modal-body">
          {{csrf_field()}}   


          <div class="form-group">
            <label for="name2" >{{ __('Nombre') }}</label>
            <input id="name2" type="text" class="form-control" name="name2"  required autofocus>
            <input id="iduser" type="hidden" name="iduser" required>
          </div>

          <div class="form-group">
            <label for="email2" >{{ __('E-Mail *Único') }}</label>
            <input id="email2" type="email" class="form-control" name="email2" required>
          </div>



          <div class="alert alert-danger alert-with-icon mess" style="display: none" data-notify="container">
            <div class="container">
            <div class="alert-wrapper">
              <div class="message"></div>
            </div>
            </div>
          </div>           

        </div>

        <div class="modal-footer">
          <div class="left-side">
            <button  class="btn btn-default btn-link"  id="sendUpdateUser">Actualizar</button>
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
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


  <script>
     


  </script>
 
@endsection

