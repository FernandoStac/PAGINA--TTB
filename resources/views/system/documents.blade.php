@extends('layouts.public')
@section('title','Inicio')

@section('content')

<div class="wrapper">
    <div class="page-header page-header-xs" data-parallax="true" style="background-image: url('{{ asset('assets/img/fabio-mangione.jpg') }}');">
        <div class="filter"></div>
    </div>              
</div>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1>Documentos cargados</h1>
    <a type="button" href="{{url('system/document/load')}}" class="btn btn-default "><i class="fa fa-file-pdf-o"></i> Cargar documento</a>
  </div>
</div>


<div class="container">  
  <div class="row">
    <div class="col-md-12">
         
      @if(session('notification'))
      <div class="alert alert-success">
        {{session('notification')}}
      </div>
      @endif

      @if(!count($documents)==0)

        @if($role==1)
        <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <div class="form-group">
            <h3 class="bg-warnig">Descarga de archivos por rango de fecha</h3>
          </div>
          <form action="{{ url('create-zip')}}" method="post">
            @csrf
            <div class="form-group">
              <label for="fechainial">Fecha Inicial</label>
              <input type="date" class="form-control" id="fechainicial" name="fechainicial" placeholder="" required="">
              <input type="hidden" class="form-control" id="douwload" name="download" value="zip">
            </div>

            <div class="form-group">
              <label for="fechafianal">Fecha Final</label>
              <input type="date" class="form-control" id="fechafinal" name="fechafinal" placeholder="" required="">
            </div>


            <div class="form-group">
              <button class="btn btn-danger" type="submit" >Download ZIP</button>
              <!-- <a href="{{ route('create-zip',['download'=>'zip']) }}" class="btn btn-info" >Download ZIP</a>  -->
            </div>
                 
              
          </form>
        </div>
        <div class="col-md-3"></div>
        @endif

     
      </div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Dueño</th>
              <th scope="col">Nombre</th>
              <th scope="col">url</th>
              <th scope="col">Fecha de carga</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
           
          <tbody>

            @foreach($documents as $key => $document)
                

            <tr>
              <th scope="row">{{$key=$key+1}}</th>
              <td>{{$document->name_user}}</td>
              <td>{{$document->name}}</td>
              <td>
                    <a class="text-danger" href="{{url($document->url)}}">{{$document->document}}</a>
              </td>
              <td>{{$document->created_at->format('d/m/Y')}}</td>
              <td class="text-success">
                <form action="{{url('/system/document/delete/'.$document->id.'')}}" method="post">
                                 {{csrf_field()}}
                                 {{method_field('DELETE')}}
                  <button type="submit" rel="tooltip" title="Eliminar producto de la faz de la Tierra" class="btn btn-danger btn-simple btn-xs">
                                <i class="fa fa-times"></i>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
           
          </tbody>
        </table>

        {{$documents->links()}}
      
      @else
      <div class="alert alert-info">
          <div class="container">
              <span>No cuenta con ningun documento cargado :) </span>
          </div>
      </div>
      @endif
          
    </div>
  </div>
    
</div>




@include('includes.footer')
@endsection

