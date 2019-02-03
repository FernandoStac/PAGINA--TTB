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
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i>Administración de permisos</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <button class="btn btn-link" onclick="st_newPermiso();"><i class="fa fa-building"></i> Nuevo permiso</button>
          </li>
 
        </ul>
      </div>
  </div>
</nav>
<br>





<div class="container">  
  <div class="row">
    <div class="col-md-12">

        <table id="accessTable" class="display table">
          <td>
            <thead class="thead-dark">
              <tr>
                  <th>Nombre</th>
                  <th>Menu</th>
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




<div class="modal fade" id="form_Permiso_options" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Permisos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="updatePermisoForm" method="post" class="">
        <div class="modal-body">
          {{csrf_field()}}   


          <div class="form-group">
            <label for="name" >Nombre</label>
            <input id="name" type="text" class="form-control" name="name"  required autofocus>
            <input id="id" type="hidden" name="id" required>
          </div>


          <div class="form-group">
            <label for="menuvalue" >Menu al que pertenece</label>
            <select class="form-control" id="menuvalue" name="menuvalue">options</select>
          </div>




                  

        </div>

        <div class="modal-footer">
          <div class="left-side">
            <button  class="btn btn-default btn-link" id="sendUpdatePermiso" value="update">Actualizar</button>
      
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
    var btnUS = document.getElementById("sendUpdatePermiso");
    var table;


    $(document).ready(function() {

      fetch("{{ url('/menu/get') }}")
      .then(data=> data.json())
      .then(menus=> {
        arr=menus.data;
        console.log(arr);
         var sel = $('#menuvalue').append();
          $(arr).each(function() {
           sel.append($("<option>").attr('value',this.val).text(this.text));
          });
          table=loadTable();
        });



     

      



      $('#accessTable tbody').on( 'click', '#permiso_update', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $("#id").val(data.id);
        $("#name").val(data.name);
        $("#menuvalue").val(data.idmenu);  
        $('#form_Permiso_options').modal('show');


      });


      

      $('#accessTable tbody').on( 'click', '#role_access', function () {
        var data = table.row( $(this).parents('tr') ).data(); 
        alert(data.id);
      });




      jQuery('#updatePermisoForm').on('submit', function(e) {
        e.preventDefault();
        
        $("#sendUpdatePermiso").prop("disabled", true);
        var formData = new FormData(this);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });

        var request=document.getElementById("sendUpdatePermiso").value;
          if(request=='new'){
            f_newPermiso(formData,table);
            btnUS.value = "update";
            btnUS.innerHTML = 'Actualizar';
          }else{
            f_updatePermiso(formData,table);
          }
      });

    });

    function loadTable(){
      $('#accessTable thead tr').clone(true).appendTo( '#accessTable thead' );
      $('#accessTable thead tr:eq(1) th').each( function (i) {
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

       table= $('#accessTable').DataTable( {
          "ajax": '{{url("/access/show")}}',
          "columns": [
            { data: "name" },
            { data: "nameMenu" },
            { "defaultContent": '<button id="permiso_update" class="btn btn-info" onclick="" >Editar' }
          ],
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },
           orderCellsTop: true,

      });

       return table;
    }
    function f_updatePermiso(formData,table){
      jQuery.ajax({
        url: "{{ url('/access/update') }}",
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
              title: 'Permiso Actualizado',
              type: 'success'
            });
          
          $('#form_Permiso_options').modal('hide');
          table.ajax.reload();
          }
          $("#sendUpdatePermiso").prop("disabled", false);
               
        },error: function(jqXHR, text, error){
          Swal({
            title: jqXHR+' '+text+' '+error,
            type: 'error'
          });

          $("#sendUpdatePermiso").prop("disabled", false);
        }
      });

    }


    function st_newPermiso(){
      btnUS.value = 'new'; 
      btnUS.innerHTML = 'Guardar';
      document.getElementById('updatePermisoForm').reset();
      $('#form_Permiso_options').modal('show');

    }


   
    function f_newPermiso(formData,table){
      jQuery.ajax({
        url: "{{ url('/access/new') }}",
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
              title: 'Permiso Guardado',
              type: 'success'
            });
          
            $('#form_Permiso_options').modal('hide');

            table.ajax.reload();
          }
          
          $("#sendUpdatePermiso").prop("disabled", false);
        },error: function(jqXHR, text, error){
          Swal({
            title: jqXHR+' '+text+' '+error,
            type: 'error'
          });

          $("#sendUpdatePermiso").prop("disabled", false);
        }
      });
    }
               

     
  </script>
 
@endsection

