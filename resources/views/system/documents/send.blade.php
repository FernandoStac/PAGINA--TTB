@extends('layouts.mail')


@section('content')

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h5 class="display-3">Archivo cargado con éxito</h5>
  </div>
</div>

<div class="div ">
  <div class="container ">
    <div class="row">
      <div class="col md-3"></div>
      <div class="col-md-6">

        <a class="text-danger" href="{{url($filename)}}">click aqui para ver el archivo cargado</a>
      </div>

      <div class="col md-3"></div>
    </div>
  </div>
</div>

@endsection

