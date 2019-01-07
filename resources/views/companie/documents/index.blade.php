@extends('layouts.public')
@section('title','Inicio')

@section('content')

<div class="wrapper">
    <div class="page-header page-header-xs" data-parallax="true" style="background-image: url('{{ asset('assets/img/fabio-mangione.jpg') }}');">
        <div class="filter"></div>
    </div>              
</div>


<nav class="navbar navbar-expand-md bg-dark">
  <div class="container">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i> {{$companie->name}}</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
      </div>
  </div>
</nav>
<br>
<br>
<br>



<div class="container">  
  <div class="row">
    <div class="col-md-12">
               <!-- <button class="btn btn-success" id="st_hola" onclick="st_hola();">hola</button> -->
      @if(session('notification'))
      <div class="alert alert-success">
        {{session('notification')}}
      </div>
      @endif

      @if(!count($documents)==0)



        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Dueño</th>
              <th scope="col">Serie</th>
              <th scope="col">Folio</th>
              <th scope="col">url</th>
              <th scope="col">Fecha</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
           
          <tbody>

            @foreach($documents as $key => $document)
                

            <tr>
              <th scope="row">{{$key=$key+1}}</th>
              <td>{{$document->name_user}}</td>
              <td>{{$document->serie}}</td>
              <td>{{$document->folio}}</td>
              <td>
                    <a class="text-danger" target="_blank" href="{{url($route.$document->url.$document->document)}}">{{url($route.$document->url.$document->document)}}</a>
              </td>
              <td>{{$document->created_at->format('d/m/Y')}}</td>
              <td class="text-success">
             
                <button class="btn btn-danger" onclick="st_delete({{$document->id}});"><i class="fa fa-times"></i></button>
              </td>
            </tr>
            @endforeach
           
          </tbody>
        </table>

        {{$documents->links()}}
      
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




@include('includes.footer')
@endsection

@section('scripts')
<script type="text/javascript">
  

  function st_delete(id){
    var urlid="{{url('/document/delete/')}}";



        Swal({
        title: 'Esta seguro de eliminarlo?',
        text: "No se podra revertir!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!'
      }).then((result2) => {
        if (result2.value) {


    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

   jQuery.ajax({
      url: urlid,
      method: 'post',
      dataType: "JSON",
      data: {"id":id},
      success: function(result){ 

        Swal({
          title: result,
          type: 'success'
              }).then(function(){ 
         location.reload();
         }
      );



       
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

</script>

@endsection


