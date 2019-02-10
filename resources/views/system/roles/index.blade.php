@extends('layouts.public')
@section('title','Inicio')

@section('css')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
@endsection

@section('content')




<nav class="navbar navbar-expand-md bg-danger">
  <div class="container">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i> Administración de roles</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">
          @if(App\Access::canEnter("Crear rol"))
          <li class="nav-item">
            <button class="btn btn-link" onclick="st_newRole();"><i class="fa fa-building"></i> Nuevo Role</button>
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
    <div class="col-md-12">
        <table id="usersTable" class="display table">
          
            <thead class="thead-dark">
              <tr>
                  <th >Role</th>
                  <th>Tipo</th>
                  <th>Acciones</th>
              </tr>
          </thead>
        

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
      <form id="updateRole" method="post" class="">
        <div class="modal-body">
          {{csrf_field()}}   


          <div class="form-group">
            <label for="role2" >Role</label>
            <input id="role2" type="text" class="form-control" name="role2"  required autofocus>
            <input id="idrole" type="hidden" name="idrole" required>
          </div>

          <div class="form-group">
            <label for="tipo2" >Tipo</label>
            <select id="tipo2" name="tipo2" class="form-control form-control-lg">
              <option value="provee">Proveedor</option>
              <option value="admin">Administrador</option>
            </select>
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
            <button  class="btn btn-default btn-link" id="sendUpdateRole" value="update">Actualizar</button>
      
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
  <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


  <script>
    var btnUS = document.getElementById("sendUpdateRole");


    $(document).ready(function() {

      $('#usersTable thead tr').clone(true).appendTo( '#usersTable thead' );
      $('#usersTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
         
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );

      });

      var table= $('#usersTable').DataTable( {
          "ajax": '{{url("/api/roles")}}',
          "columns": [
            { data: "name" },
            { data: "tipo" },
            { "defaultContent": '<button id="role_update" class="btn btn-info" onclick="" >Editar</button> - <button id="role_delete" class="btn btn-danger" onclick="" >Eliminar</button> - <button id="role_access" class="btn btn-success" onclick="" >Permisos</button>' }
          ],
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },
           orderCellsTop: true
      });



      $('#usersTable tbody').on( 'click', '#role_update', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $("#iduser").val(data.id);
        $("#role2").val(data.name);
        $("#tipo2").val(data.tipo);
        $("#idrole").val(data.id);  
        $('#myModal2').modal('show');


      });


      $('#usersTable tbody').on( 'click', '#role_delete', function () {
        var data = table.row( $(this).parents('tr') ).data(); 
        f_deleteRole(data.id,table)
      });


      $('#usersTable tbody').on( 'click', '#role_access', function () {
        var data = table.row( $(this).parents('tr') ).data(); 
        window.open("{{ url('/role/role_access/') }}/"+data.id+"");
        //window.open("{{ url('/role/role_access/') }}/"+data.id+"", '_blank');
      });




      jQuery('#updateRole').on('submit', function(e) {
        e.preventDefault();
        
        $("#sendUpdateRole").prop("disabled", true);
        var formData = new FormData(this);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });

        var request=document.getElementById("sendUpdateRole").value;
          if(request=='new'){
            f_newRole(formData,table);
            btnUS.value = "update";
            btnUS.innerHTML = 'Actualizar';
          }else{
            f_updateRole(formData,table);
          }
      });

    });

    function f_updateRole(formData,table){
      jQuery.ajax({
        url: "{{ url('/role/edit') }}",
        method: 'post',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(result){ 
          if(result!=1){
            Swal({
              title:result,
              type: 'error'
            });
          }else{
            Swal({
              title: 'Role Actualizado',
              type: 'success'
            });
          
          $('#myModal2').modal('hide');
          table.ajax.reload();
          }
          $("#sendUpdateRole").prop("disabled", false);
               
        },error: function(jqXHR, text, error){
          Swal({
            title: jqXHR+' '+text+' '+error,
            type: 'error'
          });

          $("#sendUpdateUser").prop("disabled", false);
        }
      });

    }


    function st_newRole(){
      btnUS.value = 'new'; 
      btnUS.innerHTML = 'Guardar';
      document.getElementById('updateRole').reset();
      $('#myModal2').modal('show');
    }


    function f_deleteRole(id,table){

      var id=id;
      Swal({
        title: '¿Está seguro de eliminarlo?',
        text: "Esto no se podra revertir!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Borrar!',
        cancelButtonText:'Cancelar'
      }).then((result) => {
        if (result.value) {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          jQuery.ajax({
            url: "{{url('/role/delete')}}",
            method: 'post',
            dataType: "JSON",
            data: {"id":id},
            success: function(result){ 
              var typem="success";

              if(result==23000){
                result="Lo sentimos pero el role tiene usuarios enlazados";
                typem="error";
              }
              Swal({
                title: result,
                type: typem
                    }).then(function(){ 
              
                    table.ajax.reload();
              });                     
            },error: function(jqXHR, text, error){
              Swal({
                title: jqXHR+' '+text+' '+error,
                type: 'error'
              });
            }
          });

        }

      });
    }

    function f_newRole(formData,table){
      jQuery.ajax({
        url: "{{ url('/role/new') }}",
        method: 'post',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(result){ 
          if(result!=1){
            Swal({
              title:result,
              type: 'error'
            });
          }else{
            Swal({
              title: 'Role Guardado',
              type: 'success'
            });
          
            $('#myModal2').modal('hide');

            table.ajax.reload();
          }
          
          $("#sendUpdateRole").prop("disabled", false);
        },error: function(jqXHR, text, error){
          Swal({
            title: jqXHR+' '+text+' '+error,
            type: 'error'
          });

          $("#sendUpdateUser").prop("disabled", false);
        }
      });
    }
               

     
  </script>
 
@endsection

