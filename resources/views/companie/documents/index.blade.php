@extends('layouts.public')
@section('title','Inicio')

@section('css')

 
@endsection
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
        <table class="table" id="documentsProvee">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Status</th>
              <th scope="col">Serie</th>
              <th scope="col">Folio</th>
              <th scope="col">Opciones</th>
              <th scope="col">Fecha</th>
              <th scope="col">XML</th>
            </tr>
          </thead>
           
          <tbody>

            @foreach($documents as $key => $document)
                

            <tr>
              <th scope="row">{{$document->id}}</th>
              <td>{{$document->estatus}}</td>
              <td>{{$document->serie}}</td>
              <td>{{$document->folio}}</td>
              
              <td>
                 
              <a class="text-success font-weight-bold" target="_blank" href="{{url($route.$document->url.$document->document)}}">Ver <i class="fa fa-eye"></i>
                    </a> - 
                    <a class="text-info"  href="#" onclick="st_infoDcument('{{$document->observ_1}}','{{$document->observ_2}}','{{$document->document}}');"><i class="fa fa-question-circle"></i> </a>
                    
              </td>
              <td>{{$document->created_at->format('d/m/Y')}}</td>
              <!-- <td>{{$document->folio}}</td> -->
              <td>     
              @if($document->xml)
                    <a class="text-success font-weight-bold" target="_blank" href="{{url($route.$document->url.$document->document)}}">Ver XML<i class="fa fa-eye"></i> 
                    
                    @else<a class="text-notsuccess font-weight-bold" target="_black" >Ver XML<i class="fa fa-eye"></i> 
                    </a> 
                    
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




@include('includes.footer')
@endsection

@section('scripts')

<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

  var table;

  $(document).ready(function() {

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
           "order": [[ 5, "desc" ]],
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
            '<p class="bg-light text-dark"><i class="fa fa-eye"></i>Ver el documento en otra pestaña</p>'+
            '<p class="bg-light text-dark"><i class="fa fa-question-circle"></i>Información del seguimiento</p>',
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


