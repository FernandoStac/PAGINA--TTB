@extends('layouts.public')
@section('title','Inicio')

@section('css')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
@endsection

@section('content')




<nav class="navbar navbar-expand-md ">
  <div class="container">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i> Permisos al role <span class="text-info">{{$role->name}}</span></a>
      <form><input type="hidden" name="id_role" id="id_role" value="{{$role->id}}"></form>
      <div class="collapse navbar-collapse" id="navbar-primary">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <button class="btn btn-link"><i class="fa fa-building"></i> </button>
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

    <!-- <form "id="access" method="post" class=""> -->
      @php ($cont = 1)
      @php ($actual = "")
      @foreach($accesses as $access)
      @php ($i = $access->namemenu)
      @if($actual!=$access->namemenu)
        <div class='col-md-12'><h2 class="text-info">{{$i}}</h2></div>
        @php ($actual = $access->namemenu)
      @endif
      @if($access->estatus)
        @php ($estatus = 'checked')
        @else
         @php ($estatus = '')
      @endif
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa fa-building"></i>  {{$access->name}}</h5>

              <form class="register-form">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" id="{{$access->id}}" value="{{$access->id}}" {{$estatus}}>
                          Estatus
                        <span class="form-check-sign"></span>
                    </label>
                </div>
                    <input type="hidden" id="per{{$access->id}}" value="{{$access->name}}">
              </form>

              
            </div>
          </div>
        </div>
        @php ($estatus ="")
      @endforeach
    <!-- </form> -->
  </div>
</div>
<div id="ohsnap" ></div>





@include('includes.footer')
@endsection

@section('scripts')
<script src="{{ asset('assets/js/ohsnap.js') }}"></script>

  <script>
           
 $('.container').on( 'click', '.form-check-input', function () {
          var id=this.id;
          var checked=this.checked;
         
              var id_role = document.getElementById("id_role").value;
               var permiso=document.getElementById("per"+id+"").value;




                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            jQuery.ajax({
                              url: "{{url('/access/update_to_role')}}",
                              method: 'post',
                              dataType: "JSON",
                              data: {"id":id,"estatus":checked,"id_role":id_role},
                              success: function(result){ 

                               //  Swal({
                               //    title: result,
                               //    type: 'success'
                               //        }).then(function(){ 
                               //   location.reload();
                               //   }
                               // );
                               var c;
                               var m;
                               if(result==1){
                                   c="green";
                                   m="Agregado";
                               }else{
                                  c="red";
                                  m="Eliminado";
                               }


                                  ohSnap("Acceso a : "+permiso+" => "+m, {color: c,duration:2000});
                               
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

      });

     
  </script>
 
@endsection

