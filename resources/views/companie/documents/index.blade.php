@extends('layouts.public')
@section('title','Documentos')
@section('content')

<nav class="navbar navbar-expand-md bg-light">
  <div class="container-fluid">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand text-dark" href="#"><i class="fa fa-building"></i>Información de documentos cargados</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <button class="btn btn-link text-dark"  onclick="st_infoColores();"><i class="fa fa-address-book"></i> Ayuda?</button>
          </li>
 
        </ul>
      </div>
  </div>
</nav>
<br>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      @if(!count($documents)==0)
      <div class="table-responsive">
        <table  class="table" id="documentsProvee">
          <thead class="thead-dark">
            <tr>
              <th scope="col"class="text-center">#</th>
              <th scope="col"class="text-center">Status</th>
              <th scope="col"class="text-center">Serie</th>
              <th scope="col" class="text-center" >Folio</th>
              <th scope="col"class="text-center">Fecha</th>
              <th scope="col"class="text-center">Tipo</th>
              <th scope="col"class="text-center">Acciones</th>
            </tr>
          </thead>    
          <tbody>
            @foreach($documents as $document)
            <tr>        
              <th scope="idvalues"title="Identificador del documento">{{$document->id}}</th>
              <td class="text-center"title="Estatus del documento">{{$document->estatus}}</td>
              <td class="text-center"title="Serie del documento">{{$document->serie}}</td>
              <td class="text-center" title="Folio del documento">{{$document->folio}}</td>
              <td class="text-center"title="Fecha de cargado">{{$document->created_at}}</td>
              <td class="text-left"title="Tipo de documento">{{$document->tipo}}</td>
              <td class="text-left"> 
              <a class="text-info font-weight-bold" title="Ver comentarios del seguimiento de las evaluaciones" data-placement="left"  data-toggle="tooltip"   href="#" onclick="st_infoDcument('{{$document->observ_1}}','{{$document->observ_2}}','{{$document->observ_2}}');">Comentarios <i class="fa fa-comments-o" aria-hidden="true"></i>
              <a onClick="window.open('{{url($route.$document->url.$document->document)}}','ventana','width=800,heigth=600');" title="Ver archivo PDF" data-placement="left"  data-toggle="tooltip" class="text-success font-weight-bold" href="#">- PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>   
              @if($document->xml)
                <a onClick="window.open('{{url($route.$document->url.$document->namexml)}}','ventana','width=800,heigth=600');" title="Ver archivo XML" data-placement="bottom"  data-toggle="tooltip"  class="text-success font-weight-bold" href="#">- XML<i class="fa fa-file-code-o"></i> 
              @endif      
              </td>
            </tr>
            @endforeach
           
          </tbody>
        </table>
      </div>
        {{$documents->links()}}
      
      @else
      <br>
      <br>
      <br>
      <br> 
      <h3 class="text-danger">No cuenta con ningun documento cargado </h3>
      <br>
      <br>
      <br>
      <br>
      @endif   
    </div>
  </div>   
</div>
@endsection

@section('scripts')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
  var table;
  $(document).ready(function() {
    $('a').on('shown.bs.tooltip', function () {
      setTimeout(function() {   //calls click event after a certain time
          $('[data-toggle="tooltip"]').tooltip('hide');
        }, 2000);
    });

    $('#documentsProvee thead tr').clone(true).appendTo( '#documentsProvee thead' );
    $('#documentsProvee thead tr:eq(1) th').each( function (i) {
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
     
    table= $('#documentsProvee').DataTable( {
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          },"paging":false,
           orderCellsTop: true,
           "order": [[ 4, "desc" ]],
           columnDefs:[{targets:4, render:function(data){
              return moment(data).format('D/MM/Y');
            }}],
            rowCallback: function(row, data, index){
                if(data[1] == "Rechazado"){
                    //$(row).css('background-color', 'blue');
                    $( row ).addClass( "bg-danger text-light");
                    $('td a', row).addClass('text-light');
                    $('td a', row).removeClass('text-success text-info text-danger');
                }
                if(data[1] == "Aceptado"){
                    //$(row).css('background-color', 'blue');
                    $( row ).addClass( "bg-success text-light");
                    $('td a', row).addClass('text-light');
                    $('td a', row).removeClass('text-success text-info text-danger');
                }

            }
    });
  });

  function st_infoColores(){
    Swal({
      title:'Información',
      html: '<p class="bg-danger text-light"> Documentos que fueron rechazados</p>'+
            '<p class="bg-success text-light"> Documentos aceptados por el receptor</p>'+
            '<p class="bg-light text-dark"> Documentos que aun no se han revisado</p>'+
            '<p class="bg-light text-dark"><i class="fa fa-file-pdf-o"></i> Ver el documento en otra pestaña</p>'+
            '<p class="bg-light text-dark"><i class="fa fa-comments-o"></i> Información del seguimiento</p>'+
            '<p class="bg-light text-dark"><i class="fa fa-file-code-o"></i> Icono solo si cuenta con XML</p>',
      type: 'info'
    });
  }

  function st_infoDcument(m1,m2,m3){
    let ms="Información";
    if(m1=="" & m2=="" & m3==""){
      ms="Sin observaciones";
    }
    Swal({
      title:ms,
      html: '<p class="">Obervación 1: '+ m1+'</p>'+
            '<p class="">Obervación 2: '+ m2+'</p>'+
            '<p class="">Obervación 3: '+ m3+'</p>',
      type: 'info'
    });
  }

</script>

@endsection


