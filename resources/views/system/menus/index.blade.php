@extends('layouts.public')
@section('title','Inicio')

@section('css')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
@endsection

@section('content')




<nav class="navbar navbar-expand-md bg-success">
  <div class="container">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i>Menú</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <button class="btn btn-link" onclick="st_newMenu();"><i class="fa fa-building"></i> Nuevo Menu</button>
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
        <table id="menusTable" class="display table">
          <td>
            <thead class="thead-dark">
              <tr>
                  <th >Nombre</th>
                  <th>Ruta</th>
                  <th>Orden de aparicion</th>
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




<div class="modal fade" id="form_menu_options" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="updateMenuForm" method="post" class="">
        <div class="modal-body">
          {{csrf_field()}}   


          <div class="form-group">
            <label for="name" >Nombre</label>
            <input id="name" type="text" class="form-control" name="name"  required autofocus>
            <input id="id" type="hidden" name="id" required>
          </div>
          <div class="form-group">
            <label for="route" >Route</label>
            <input id="route" type="text" class="form-control" name="route">
          </div>

          <div class="form-group">
            <label for="order" >Orden de aparición</label>
            <input id="order" type="number" class="form-control" name="order"  required >
          </div>




                  

        </div>

        <div class="modal-footer">
          <div class="left-side">
            <button  class="btn btn-default btn-link" id="sendUpdateMenu" value="update">Actualizar</button>
      
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
    var btnUS = document.getElementById("sendUpdateMenu");


    $(document).ready(function() {

      $('#menusTable thead tr').clone(true).appendTo( '#menusTable thead' );
      $('#menusTable thead tr:eq(1) th').each( function (i) {
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

      } );

      var table= $('#menusTable').DataTable( {
          "ajax": '{{url("/menu/show")}}',
          "columns": [
            { data: "name" },
            { data: "route" },
            { data: "order" },
            { "defaultContent": '<button id="menu_update" class="btn btn-info" onclick="" >Editar</button> - <button id="role_access" class="btn btn-success" onclick="" >Permisos</button>' }
          ],
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },
           orderCellsTop: true,
            "order": [[ 3, "desc" ]]
      });



      $('#menusTable tbody').on( 'click', '#menu_update', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $("#id").val(data.id);
        $("#name").val(data.name);
        $("#route").val(data.route);
        $("#order").val(data.order);  
        $('#form_menu_options').modal('show');


      });


      

      $('#usersTable tbody').on( 'click', '#role_access', function () {
        var data = table.row( $(this).parents('tr') ).data(); 
        alert(data.id);
      });




      jQuery('#updateMenuForm').on('submit', function(e) {
        e.preventDefault();
        
        $("#sendUpdateMenu").prop("disabled", true);
        var formData = new FormData(this);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });

        var request=document.getElementById("sendUpdateMenu").value;
          if(request=='new'){
            f_newMenu(formData,table);
            btnUS.value = "update";
            btnUS.innerHTML = 'Actualizar';
          }else{
            f_updateMenu(formData,table);
          }
      });

    });

    function f_updateMenu(formData,table){
      jQuery.ajax({
        url: "{{ url('/menu/update') }}",
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
              title: 'Menu Actualizado',
              type: 'success'
            });
          
          $('#form_menu_options').modal('hide');
          table.ajax.reload();
          }
          $("#sendUpdateMenu").prop("disabled", false);
               
        },error: function(jqXHR, text, error){
          Swal({
            title: jqXHR+' '+text+' '+error,
            type: 'error'
          });

          $("#sendUpdateMenu").prop("disabled", false);
        }
      });

    }


    function st_newMenu(){
      btnUS.value = 'new'; 
      btnUS.innerHTML = 'Guardar';
      document.getElementById('updateMenuForm').reset();
      $('#form_menu_options').modal('show');

    }


   
    function f_newMenu(formData,table){
      jQuery.ajax({
        url: "{{ url('/menu/new') }}",
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
              title: 'Menu Guardado',
              type: 'success'
            });
          
            $('#form_menu_options').modal('hide');

            table.ajax.reload();
          }
          
          $("#sendUpdateMenu").prop("disabled", false);
        },error: function(jqXHR, text, error){
          Swal({
            title: jqXHR+' '+text+' '+error,
            type: 'error'
          });

          $("#sendUpdateMenu").prop("disabled", false);
        }
      });
    }
               

     
  </script>
 
@endsection

