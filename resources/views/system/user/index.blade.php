@extends('layouts.public')
@section('title','Inicio')

@section('css')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
@endsection

@section('content')
<!-- 
<div class="wrapper">
    <div class="page-header page-header-xs" data-parallax="true" style="background-image: url('{{ asset('assets/img/fabio-mangione.jpg') }}');">
        <div class="filter"></div>
    </div>              
</div>
 -->



<nav class="navbar navbar-expand-md bg-danger">
  <div class="container">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i> Administración de usuario</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-building"></i> Nuevo usuario</a>
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





<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="newUser" method="post" class="">
        <div class="modal-body">
          {{csrf_field()}}   

          <div class="form-group">
            <label for="rol">Tipo de usuario</label>
            <select class="form-control" name="rol" id="rol" required="" onchange="showCompanie(this.value)">
            <option value="">Selecione un rol</option>
                @foreach($roles as $rol)
            <option value="{{$rol->id}}">{{$rol->name}}</option>
                @endforeach
            </select>
          </div>


          <div class="form-group" style="display: none" id="fieldCompanie">
            <label for="rol">Empresa a la que pertenece</label>
            <select class="form-control" name="companie" id="companie" required="">
              <option value="">Selecione una empresa</option>
                @foreach($companies as $com)
              <option value="{{$com->id}}">{{$com->name}}</option>
                @endforeach
            </select>
          </div>


          <div class="form-group">
            <label for="name" >{{ __('Nombre') }}</label>
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
            @if ($errors->has('name'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
            @endif
          </div>

          <div class="form-group">
            <label for="email" >{{ __('E-Mail *Único') }}</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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
            <button  class="btn btn-default btn-link"  id="sendNewUser">Guardar</button>
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
      var edit="{{url('/')}}"



      $(document).ready(function() {
        //reset values
        $('#newUser')[0].reset();
        $("#companie").prop("required", false);

        //load users
        var table= $('#usersTable').DataTable( {
            "ajax": '{{url("/api/user")}}',
            "columns": [
                { data: "userName" },
                { data: "companieName" },
                { data: "roleName" },
                { data: "userEmail" },
                {"defaultContent": '<button type="button" id="ButtonEditar" class="editar edit-modal btn btn-info botonEditar"><span class="fa fa-edit"></span><span class="hidden-xs"> Editar</span></button>'}
            ],

            "language": {
              "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });

        //event to edit a user
        $('#usersTable tbody').on( 'click', 'button', function () {
          var data = table.row( $(this).parents('tr') ).data();
           $("#iduser").val(data.id);
           $("#name2").val(data.userName);
           $("#email2").val(data.userEmail);
           jQuery('.mess').hide();
          $('#myModal2').modal('show');

        });


        ///////updateUser


        jQuery('#updateUser').on('submit', function(e) {
          e.preventDefault();

          $("#sendUpdateUser").prop("disabled", true);

          var formData = new FormData(this);
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
          });



          jQuery.ajax({
            url: "{{ url('/system/edit/user.html') }}",
            method: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result){ 
              if(result=="rpt"){
                jQuery('.message').html('El correo debe ser único, ingrese otro');
                jQuery('.mess').show();
              }else{
                $('#myModal2').modal('hide');
                jQuery('.mess').hide();
                table.ajax.reload();
              }

              $("#sendUpdateUser").prop("disabled", false);
               

            },error: function(jqXHR, text, error){
              alert(jqXHR);alert(text);alert(error);
              $("#sendUpdateUser").prop("disabled", false);
            }
          });

        });





        /////////////////////////////////////////////////////////////

        //send a new user
        jQuery('#newUser').on('submit', function(e) {
          e.preventDefault();

          $("#sendNewUser").prop("disabled", true);

          var formData = new FormData(this);
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
          });



          jQuery.ajax({
            url: "{{ url('/system/user.html') }}",
            method: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result){ 
              if(result=="rpt"){
                jQuery('.message').html('El correo debe ser único, ingrese otro');
                jQuery('.mess').show();
              }else{
                $("#companie").prop("required", false);
                $("#fieldCompanie").hide();
                $('#newUser')[0].reset();
                $('#myModal').modal('hide');
                jQuery('.mess').hide();
                table.ajax.reload();
              }

              $("#sendNewUser").prop("disabled", false);
               

            },error: function(jqXHR, text, error){
              alert(jqXHR);alert(text);alert(error);
              $("#sendNewUser").prop("disabled", false);
            }
          });



        });



      });



      function showCompanie(){
        var rol=$("#rol").val();
        if(rol==3){
          $("#fieldCompanie").show();
          $("#companie").prop("required", true);
        }else{
          $("#fieldCompanie").hide();
          $("#companie").prop("required", false);
        }
      }


  </script>
 
@endsection

