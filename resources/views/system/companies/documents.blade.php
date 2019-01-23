@extends('layouts.public')
@section('title','Documentos')


@section('css')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
@endsection

@section('content')

<!-- <div class="wrapper ">
    <div class="page-header page-header-xs" data-parallax="true" style="background-image: url('{{ asset('assets/img/fabio-mangione.jpg') }}');">
        <div class="filter"></div>
    </div>              
</div>
 -->

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
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#empresaModal"><i class="fa fa-building"></i> Editar empresa</a>
          </li>
        </ul>
      </div>
  </div>
</nav>
<br>
<br>
<br>
<br>
<br>




<div class="container-fluid">  
  <div class="row">
    <div class="col-md-12">
         
      @if(session('notification'))
      <div class="alert alert-success">
        {{session('notification')}}
      </div>
      @endif
        <div id="datos">  </div>
      @if(!count($documents)==0)
<div class="table-responsive">
      
        <table class="table table" id="myTable">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Proveedor</th>
              <th scope="col">Serie</th>
              <th scope="col">Folio</th>
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
                    <a class="btn btn-danger btn-sm" target="_blank" href="{{url($route.$document->url.$document->document)}}">
                      <!-- {{url($route.$document->url.$document->document)}}  -->Ver
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
      <div class="alert alert-info">
          <div class="container">
              <span>No cuenta con ningun documento cargado :) </span>
          </div>
      </div>
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
  
  $(document).ready( function () {

     $('#myTable thead th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="'+title+'" />' );
            } );

     var table= $('#myTable').DataTable({
        "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "paging":false,

            ////////////////7
        // "columns": [
        //     { "searchable": false },
        //     null,
        //     null,
        //     null,
        //      { "searchable": false },
        //     null
        //   ] ,
        //    "order": [[ 5, "desc" ]]
      /////////////7
      });


            // Setup - add a text input to each footer cell
       
         
            // DataTable
            //var table = $('#myTable').DataTable();
         
            // Apply the search
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
  


  } );



  function va(){
    var table = $('#myTable').DataTable();
      
 
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
  
</script>
@endsection