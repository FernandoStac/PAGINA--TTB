@extends('layouts.public')
@section('title','Documentos')
@section('content')
<nav class="navbar navbar-expand-md fixed-bottom bg-danger">
  <div class="container">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i> {{$companie->name}}</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-file-pdf-o"></i> Descargar facturas por fecha</a>
          </li>

          <li class="nav-item">
            <form id="byFilter" action="{{ url('create_zip_filter')}}" method="post">
              {{csrf_field()}}
              <input type="hidden" id="fieldValues" name="fieldValues">
            <a class="nav-link" href="#"   onclick="idGet()"><i class="fa fa-file-pdf-o"></i> Descargar por filtro</a>
            </form>
          </li>
    

          @if(App\Access::canEnter("Editar empresas"))
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#empresaModal"><i class="fa fa-building"></i> Editar empresa</a>
          </li>
          @endif
        </ul>
      </div>
  </div>
</nav>


  <form>
    <input type="hidden" name="tipo_evaluador" id="tipo_evaluador" value="{{$evaluacion_tipo}}">
    <input type="hidden" name="ncompany" id="ncompany" value="{{$companie->name_short}}">
  </form>

<div class="jumbotron jumbotron-fluid">
  <div class="container-fluid">
      <h2 class="">{{$companie->name}} <span class="small">{{$evaluacion}}</span></h2>
  </div>
</div>
<div class="container-fluid">  
  <br>   
  <div class="row">

 
            <div class="col-md-3">                 
              <div class="form-group">
                  <div class='input-group date' id='datetimepickerr'>
                      <input type='text' class="form-control datepicker"  name="start_date" id="start_date" placeholder="Fecha Inicio" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                      </span>
                  </div>
              </div>
            </div>   
          <div class="col-md-3">
            <div class="form-group">
                <div class='input-group date' id='datetimepickerr2'>
                    <input type='text' name="end_date" id="end_date" class="form-control datetimepicker" placeholder="Fecha Fin" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    </span>
                </div>
            </div>
          </div>

            
          <div class="col-md-3">    
            <div class="form-group">
               <input type="button" name="searchdate" id="searchdate" value="Filtrar" class="btn btn-danger btn-sm form-control" />       
              </div>
           </div>


    <div class="col-md-12">
      <div class="table-responsive">
        <table class="display table dataTable no-footer" id="documentsevaluation">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Proveedor</th>
              <th scope="col">Serie</th>
              <th scope="col">Folio</th>
              <th scope="col">Estatus</th>
              <th scope="col">Observaciones1</th>
              <th scope="col">Tipo</th>
              <th scope="col">Fecha</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
           
 

        </table>
        </div>
        <br>
      <br>
      <br>
      <br>
      <br>      
    </div>
  </div>
    
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Rango de fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <form action="{{ url('create-zip')}}" method="post">
            <div class="modal-body">

              
                  @csrf
            <div class="form-group">
              <label for="fechainial">Fecha Inicial</label>
              <input type="date" class="form-control" id="fechainicial" name="fechainicial" placeholder="" required="">
              <input type="hidden" class="form-control" id="download" name="download" value="zip">
            </div>

            <div class="form-group">
              <label for="fechafianal">Fecha Final</label>
              <input type="date" class="form-control" id="fechafinal" name="fechafinal" placeholder="" required="">
            </div>
             <input type="hidden" class="form-control" id="idem" name="idem" placeholder="Nombre de la empresa" value="{{$companie->id}}" required="">


            </div>
            <div class="modal-footer">
                <div class="left-side">
           
              <button class="btn btn-danger" type="submit" >Download ZIP</button>
          
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


<!-- Modal -->
<div class="modal fade" id="empresaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Rango de fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <form action="{{ url('/system/companie/edit/'.$companie->id)}}" method="post">
            <div class="modal-body">

               {{csrf_field()}}
                <div class="form-group">
                  <label for="name">Nombre de la empresa</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la empresa" value="{{$companie->name}}" required="">
                </div>


                <div class="form-group">
                  <label for="email">Email donde se notificara que la empresa cargo un archivo</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required="" value="{{$companie->email}}">
                </div>

            </div>
            <div class="modal-footer">
                <div class="left-side">
           
              <button class="btn btn-danger" type="submit" >Guardar</button>
          
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
  var dataTable;
  var urlglobal="{{url($route)}}"+"/";
  var masterValidator=document.getElementById("tipo_evaluador").value;

  $(document).ready( function () {
    
    
    $('#documentsevaluation thead tr').clone(true).appendTo( '#documentsevaluation thead' );
    $('#documentsevaluation  thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width:100%" class="form-control form-control-sm" placeholder="Buscar '+title+'" />' );     
        $( 'input', this ).on( 'keyup change', function () {
            if ( dataTable.column(i).search() !== this.value ) {
                dataTable
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );

      });



    $('#datetimepickerr').datetimepicker({
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      },
      format:'YYYY/MM/DD'
    });

    $('#datetimepickerr2').datetimepicker({
      icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-chevron-up",
        down: "fa fa-chevron-down",
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-remove'
      },
      format:'YYYY/MM/DD'
    });


    fetch_data('week',"","",);



    $('#searchdate').click(function(){

      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();

      if(start_date != '' && end_date !='')
      {
      $('#documentsevaluation').DataTable().destroy();
      fetch_data('yes', start_date, end_date);
      }
      else
      {
      alert("La captura de la fecha es obligada");
      }
    }); 
    

    $('#documentsevaluation tbody').on( 'click', '.document_validate', function () {
       var colu= $(this);
       st_validar(colu);
      });

    $('#documentsevaluation tbody').on( 'click', '.document_edit_fields', function () {
      var colu= $(this);
      st_edit_fields(colu);
       
    });

    $('#documentsevaluation tbody').on( 'click', '.see_pdf', function () {
      let colu= $(this);

      let name = (dataTable.row( colu.parents('tr') ).data()).document;
      let companyurl = (dataTable.row( colu.parents('tr') ).data()).url;
      let seedocument=urlglobal+companyurl+name;
      //alert(seedocument);
       window.open(seedocument,'VIsta del PDF','width=800,height=600'); 
    });

    $('#documentsevaluation tbody').on( 'click', '.see_xml', function () {
      let colu= $(this);

      let name = (dataTable.row( colu.parents('tr') ).data()).namexml;
      //alert((dataTable.row( colu.parents('tr') ).data()).xml);
      let companyurl = (dataTable.row( colu.parents('tr') ).data()).url;
      let seedocument=urlglobal+companyurl+name;
      //alert(seedocument);
      window.open(seedocument,'Vista del PDF','width=800,height=600'); 
    });

    $('#documentsevaluation tbody').on( 'click', '.document_delete', function () {
       var colu= $(this);
       st_delete(colu);
    });

  });

  function fetch_data(range_date, start_date='', end_date=''){
    var ncompany = $('#ncompany').val();
    dataTable = $('#documentsevaluation').DataTable({
      "language": {
        //"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        "sProcessing":     "Procesando...",
        "emptyTable":" Sin documentos a evaluar en estas fechas"
      },
      "processing" : true,
      "paging":false,
      orderCellsTop: true,
      "ajax" : {
        url:"{{url('/system/companie/date/get/documents')}}",
        type:"POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
          range_date:range_date, start_date:start_date, end_date:end_date ,ncompany:ncompany
        }
      },
      
      "columns": [
            { data: "id" },
            { data: "proveedor" },
            { data: "serie" },
            { data: "folio" },
            { data: "estatus" },
            { data: "observ_1" }, 
            { data: "tipo" },            
            {data: "created_at"},
            { "defaultContent": '@if(App\Access::canEnter("Evaluador 1") or App\Access::canEnter("Evaluador 2") or App\Access::canEnter("Evaluador 3") or App\Access::canEnter("Evaluador Maestro")) <a title="Validar documento" class="text-info font-weight-bold document_validate pointer" style="cursor:pointer;"><i class="fa fa-check"></i>-</a> @endif @if(App\Access::canEnter("Eliminar documentos"))<a title="Eliminar el archivo" class="text-info font-weight-bold document_delete pointer" style="cursor:pointer;"><i class="fa fa-trash"></i></a>- @endif <a title="Ver archivo PDF" class="see_pdf text-success font-weight-bold" style="cursor:pointer;"><i class="fa fa-file-pdf-o"></i></a><a class="see_xml text-success font-weight-bold" style="cursor:pointer;">-<i class="fa fa-file-code-o" title="Ver XML"></i> </a> @if(App\Access::canEnter("Editar facturas"))<a title="Editar campos" class="text-info font-weight-bold document_edit_fields pointer" style="cursor:pointer;">-<i class="fa fa-edit"></i></a> @endif' }
          
          ],
          
          columnDefs:[{targets:7, render:function(data){
              return moment(data).format('D/MM/Y');
            }}],


          rowCallback: function(row, data, index){
                if(data[ "xml"]==0){
                  $('td .see_xml', row).addClass('d-none');
                }
                if(data[ "estatus"] == "Rechazado"){
                    //$(row).css('background-color', 'blue');
                    $( row ).addClass( "bg-danger text-light");
                    if(masterValidator!=777){
                    $('td .document_validate', row).addClass('text-light d-none');
                    }
                    $('td .document_delete', row).addClass('text-light');
                    $('td .document_delete', row).removeClass('text-success text-info');
                    $('td .document_validate', row).removeClass('text-success text-info');
                }

                if(data[ "estatus"] == "Aceptado"){
                    //$(row).css('background-color', 'blue');
                    $( row ).addClass( "bg-success text-light");
                    $('td a', row).addClass('text-light');
                    if(masterValidator!=777){
                      $('td .document_validate', row).addClass('text-light d-none');
                    }
                 
                    $('td a', row).removeClass('text-success text-info');
                }

                if(data["estatus"]== "En proceso"){
                    //$(row).css('background-color', 'blue');
                    $( row ).addClass( "bg-warning text-dark");
                    if(masterValidator!=777){
                    $('td .document_validate', row).addClass('text-light d-none');
                    }
                    $('td .document_delete', row).addClass('text-light');
                    $('td .document_delete', row).removeClass('text-success text-info');
                    $('td .document_validate', row).removeClass('text-success text-info');
                }
            },
            "order": [[ 5, "desc" ]],
      });
  }
  //values from the table
  function  idGet(){
    var tbl = document.getElementById("documentsevaluation");
    var valores = [];
    if (tbl != null) {
      for (var i = 2; i < tbl.rows.length; i++) {  
        
        valores.push(tbl.rows[i].cells[0].innerHTML);
        
      }

    }

 
    $('#fieldValues').val(valores);
    
    if(valores[0]=="No matching records found"){
      Swal.fire(
        'SIn datos',
        'Descarga de archivos sin datos',
        'error'
      );
    }else{
       $('#byFilter').submit(); 
    }
   
  }


  function sendValues(dato){
          $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
             url:"{{ url('create_zip_filter')}}",
            type:'post',
            data:{ search:dato }, //Aqui tienes que enviar el objeto json
            success:function(response){
              //  console.log(response);
                if(response.zip) {
                  window.open(response.zip,'descarga','width=800,height=600');
          //  location.href = response.zip;
        }
            },
           error:function(){
              alert('Error al obtener el archivo');// solo ingresa a esta parte
           }
       });
  }





  function st_validar(colu){
    //var id=colu.closest('tr').find(".idValues").text();
    //console.log(colu.val());
   var id = (dataTable.row( colu.parents('tr') ).data()).id; 
      
    Swal.fire({
      title: 'Validar documento '+id,
      text: "You won't be able to revert this!",
      html: '<br>'+
            '<form>'+
                '<div class="form-check">'+
                    '<label class="form-check-label">'+
                        '<input class="form-check-input" type="checkbox" id="validation_document">'+
                          'Validar factura'+
                        '<span class="form-check-sign"></span>'+
                    '</label>'+
                '</div>'+
                '<div class="form-group">'+
                   '<label for="validation_document_ob" ></label>'+
                        '<input class="form-control" type="text" id="validation_document_ob" placeholder="Observación">'+
        
                '</div>'+
              '</form>',
      allowOutsideClick: false,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {


      if (result.value) {
        var  validation_document_ob = document.getElementById("validation_document_ob").value;
        var validation_document=document.getElementById("validation_document").checked;
        var tipo_evaluador=document.getElementById("tipo_evaluador").value;


        Swal({
          title: 'Notificando!',
          html: 'Espere por favor...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
          Swal.showLoading()
          
          }
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
          url: "{{url('/system/companie/documents/validate')}}",
          method: 'post',
          dataType: "JSON",
          data: {"id":id,"validation_document":validation_document,"validation_document_ob":validation_document_ob,"tipo_evaluador":tipo_evaluador},
          success: function(result){

            Swal.close();
            if(result.types=="supererror"){ 
               Swal.fire(
                  'Sin permisos',
                  'Lo sentimos pero no tiene permisos',
                  'error'
                );
             
            }else{
               Swal.fire(
                  'Validado!',
                  'El archivo fue evaluado. \n'+result.ms,
                  result.types
                );



               dataTable
                .row( colu.parents('tr') )
                .remove()
                .draw();
              //colu.closest('tr').remove();
            }

                    
           
          },error: function(jqXHR, text, error){
            Swal.close();
            Swal({
              title: jqXHR+' '+text+' '+error,
              type: 'error'
            }).then(function(){ 
            // location.reload();
             }
           );


          }
        });

      }
    })
  }

  function st_edit_fields(colu){
    //var id=colu.closest('tr').find(".idValues").text();
    //console.log(colu.val());
   var id = (dataTable.row( colu.parents('tr') ).data()).id; 
   var ob = (dataTable.row( colu.parents('tr') ).data()).observ_1; 
   var tipo = (dataTable.row( colu.parents('tr') ).data()).tipo; 
   let t1="";
   let t2="";
   if(ob===null){
     ob="";
   }
   if(tipo=="Grupos"){
      t1="selected";
   }else if(tipo=="Individuales"){
     t2="selected";
   }
      
    Swal.fire({
      title: 'Editar '+id,
      html: '<br>'+
            '<form>'+
                '<div class="form-group">'+
                        '<input class="form-control" type="text" id="obvalue" placeholder="observacion" value='+ob+'>'+
        
                '</div>'+
               '<div class="form-group">'+
                  '<label for="gruposvalue">Seleccione su tipo de factura</label>'+
                  '<select id="gruposvalue" class="form-control" >'+
                  '<option></option>'+
                   '<option '+t1+'>Grupos</option>'+
                    '<option '+t2+'>Individuales</option>'+
                   '</select>'+
                '</div>'+

              '</form>',
      allowOutsideClick: false,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {


      if (result.value) {
        var  obvalue= document.getElementById("obvalue").value;
        var gruposvalue=document.getElementById("gruposvalue").value;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
          url: "{{url('/system/companie/documents/edit_fields')}}",
          method: 'post',
          dataType: "JSON",
          data: {"id":id,"obvalue":obvalue,"gruposvalue":gruposvalue},
          success: function(result){


            if(result.types=="supererror"){ 
               Swal.fire(
                  'Sin permisos',
                  'Lo sentimos pero no tiene permisos',
                  'error'
                );
             
            }else{
               Swal.fire(
                  'Validado!',
                  'Registro actualizado \n'+result.ms,
                  result.types
                );



               dataTable.ajax.reload();
            }

                    
           
          },error: function(jqXHR, text, error){

            Swal({
              title: jqXHR+' '+text+' '+error,
              type: 'error'
            }).then(function(){ 
             location.reload();
             }
           );


          }
        });

      }
    })
  }








  function st_delete(colu){

    var id = (dataTable.row( colu.parents('tr') ).data()).id; 

    Swal.fire({
      title: 'Eliminar el documento '+id,
      text: "Esto ya no se podra revertir!",
      allowOutsideClick: false,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {


      if (result.value) {
     
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
          url: "{{url('/document/delete')}}",
          method: 'post',
          dataType: "JSON",
          data: {"id":id},
          success: function(result){
            if(result.types=="supererror"){ 
               Swal.fire(
                  'Sin permisos',
                  result.ms,
                  'error'
                );
             
            }else{
               Swal.fire(
                  'Éxito!',
                  result.ms,
                  'success'
                );



               dataTable
                .row( colu.parents('tr') )
                .remove()
                .draw();
              //colu.closest('tr').remove();
            }

                    
           
          },error: function(jqXHR, text, error){

            Swal({
              title: jqXHR+' '+text+' '+error,
              type: 'error'
            }).then(function(){ 
             location.reload();
             }
           );


          }
        });

      }
    })
  }
  
</script>
@endsection