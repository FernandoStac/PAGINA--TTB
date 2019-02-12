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
          @if(!count($documents)==0)
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
          @endif

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
  </form>

<div class="jumbotron jumbotron-fluid">
  <div class="container-fluid">
      <h2 class="">{{$companie->name}} <span class="small">{{$evaluacion}}</span></h2>
  </div>
</div>
<div class="container-fluid">  
  <div class="row">
    <div class="col-md-12">
      @if(session('notification'))
      <div class="alert alert-success">
        {{session('notification')}}
      </div>
      @endif
        <div id="datos">  </div>
      @if(!count($documents)==0 and !is_null($documents))
<div class="table-responsive">
      
        <table class="display table dataTable no-footer" id="myTable">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Proveedor</th>
              <th scope="col">Serie</th>
              <th scope="col">Folio</th>

              <th scope="col">Estatus</th>
              <th scope="col">Acciones</th>
              <th scope="col">Fecha</th>
            </tr>
          </thead>
           
          <tbody>

            @foreach($documents as $key => $document)
                

            <tr>
              <th class="idValues" scope="row">{{$document->id}}</th>
              <td>{{$document->name_user}}</td>
              <td>{{$document->serie}}</td>
         
              <td>{{$document->folio}}</td>
              <td>
                @if($evaluacion_tipo==1 or $evaluacion_tipo==777) 
                      @if(( !is_null($document->v_1) and $document->v_1==false) or  ( !is_null($document->v_2) and $document->v_2==false) or (!is_null($document->v_3) and $document->v_3==false))
                      Rechazado 
                      @elseif($document->v_1==1 and $document->v_2==1 and $document->v_3==1)
                      Aceptado
                      @elseif(($document->v_1==1 and is_null($document->v_2)) or ($document->v_1==1 and $document->v_2==1) )
                        En proceso
                      @else
                        Revisar
                       @endif
                 @elseif($evaluacion_tipo==2)
                    @if(( !is_null($document->v_2) and $document->v_2==false) or (!is_null($document->v_3) and $document->v_3==false))
                      Rechazado 
                      @elseif($document->v_1==1 and $document->v_2==1 and $document->v_3==1)
                      Aceptado
                      @elseif(($document->v_2==1 and is_null($document->v_3)) )
                        En proceso
                      @else
                        Revisar
                       @endif


                 @endif


              </td>
              <td>
                    <a class="text-success font-weight-bold" target="_blank" href="{{url($route.$document->url.$document->document)}}">Ver <i class="fa fa-eye"></i>
                    </a> - 
                    @if($evaluacion_tipo==1)


                                @if(( is_null($document->v_1) ))

                       
                          <a class="text-info font-weight-bold document_validate pointer" style="cursor:pointer;">
                              Validar <i class="fa fa-check"></i>
                            </a>
                         @endif

                  @elseif($evaluacion_tipo==2)
                                @if(( is_null($document->v_2) ))

                         
                            <a class="text-info font-weight-bold document_validate pointer" style="cursor:pointer;">
                                Validar <i class="fa fa-check"></i>
                              </a>
                           @endif
                   @elseif($evaluacion_tipo==3)
                     <a class="text-info font-weight-bold document_validate pointer" style="cursor:pointer;">
                                Validar <i class="fa fa-check"></i>
                              </a>
                  @elseif($evaluacion_tipo==777)
                     <a class="text-info font-weight-bold document_validate pointer" style="cursor:pointer;">
                                Validar <i class="fa fa-check"></i>
                              </a>
                 @endif

                  - <a class="text-info font-weight-bold document_delete pointer" style="cursor:pointer;">
                                Eliminar <i class="fa fa-trash"></i>
                              </a> 
                    
              </td>
              <td>{{$document->created_at->format('d/m/Y')}}</td>

            </tr>
            @endforeach




           
          </tbody>

        </table>
        </div>
        <br>
      <br>
        {{$documents->links()}}
      <br>
      <br>
      <br>
      <br>
      @else
      <br>
      <br>
      <br>
      <br>
      <h3 class="text-info">Sin documentos a evaluar :)</h3>
      <br>
      <br>
      <br>
      <br>
      @endif
          
    </div>
  </div>
    
</div>


<!-- Modal -->
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
   var table;
  $(document).ready( function () {
    $('#myTable thead tr').clone(true).appendTo( '#myTable thead' );
    $('#myTable  thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width:100%" class="form-control form-control-sm" placeholder="Buscar '+title+'" />' );
         
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );

      });
     // $('#myTable thead th').each( function () {
     //            var title = $(this).text();
     //            $(this).html( '<input type="text" style="width:100%" class="form-control form-control-sm" placeholder="Buscar '+title+'" />' );
     //  } );

      table= $('#myTable').DataTable({
        "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "paging":false,
          orderCellsTop: true,
        rowCallback: function(row, data, index){
                if(data[4] == "Rechazado"){
                    //$(row).css('background-color', 'blue');
                    $( row ).addClass( "bg-danger text-light");
                    $('td a', row).addClass('text-light');
                    $('td a', row).removeClass('text-success text-info');
                }

                if(data[4] == "Aceptado"){
                    //$(row).css('background-color', 'blue');
                    $( row ).addClass( "bg-success text-light");
                    $('td a', row).addClass('text-light');
                    $('td a', row).removeClass('text-success text-info');
                }

                if(data[4] == "En proceso"){
                    //$(row).css('background-color', 'blue');
                    $( row ).addClass( "bg-warning text-dark");
                    $('td a', row).addClass('text-light');
                    $('td a', row).removeClass('text-success text-info');
                }
            }
      });

    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );







    $('#myTable tbody').on( 'click', '.document_validate', function () {
       var colu= $(this);
       st_validar(colu);
      });


    $('#myTable tbody').on( 'click', '.document_delete', function () {
       var colu= $(this);
       st_delete(colu);
      });

  });



  function va(){
    // table = $('#myTable').DataTable();
      
 
          $('#datos').html(
              table
                  .columns( 0 )
                  .data()
                  .eq( 0 )      // Reduce the 2D array into a 1D array of data
                  .sort()       // Sort data alphabetically
                  .unique()     // Reduce to unique values
                  .join( '<br>' )
          );
  }
  //values from the table
  function  idGet(){
    var valores = [];
    $(".idValues").parent("tr").find("th").each(function() {
      valores.push($(this).html());
    });
    $('#fieldValues').val(valores);
     $('#byFilter').submit(); 
  }
  //send values to controller
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
                console.log(response);
                if(response.zip) {
            location.href = response.zip;
        }
            },
           error:function(){
              alert('Error al obtener el archivo');// solo ingresa a esta parte
           }
       });
  }





  function st_validar(colu){
    var id=colu.closest('tr').find(".idValues").text();
   // var data = table.row( $(this).parents('tr') ).data(); 
        //alert(data.id);
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



               table
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









  function st_delete(colu){
    var id=colu.closest('tr').find(".idValues").text();
   // var data = table.row( $(this).parents('tr') ).data(); 
        //alert(data.id);
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
                  result.types
                );



               table
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