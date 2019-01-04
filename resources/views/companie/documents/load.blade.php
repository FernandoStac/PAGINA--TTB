@extends('layouts.public')
@section('title','Inicio')

@section('content')

<div class="wrapper">
    <div class="page-header page-header-xs" data-parallax="true" style="background-image: url('{{ asset('assets/img/fabio-mangione.jpg') }}');">
        <div class="filter"></div>
    </div>              
</div>

<nav class="navbar navbar-expand-md bg-danger">
  <div class="container">
      <button class="navbar-toggler navbar-toggler-right burger-menu" type="button" data-toggle="collapse" data-target="#navbar-primary" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
          <span class="navbar-toggler-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-building"></i> Documentos</a>
      <div class="collapse navbar-collapse" id="navbar-primary">
      </div>
  </div>
</nav>
<br>
<br>
<br>

<div class="div ">
  <div class="container ">
    <div class="row">
      <div class="col md-3"></div>
      <div class="col-md-6">


        <div class="alert alert-success alert-with-icon mess" style="display: none" data-notify="container">
            <div class="container">
                <div class="alert-wrapper">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <div class="message"></div>
                </div>
            </div>
        </div>

        <div class="card text-white bg-dark" style="border-radius: 0">
          <div class="card-body">
            <p class="text-center"><i class="fa fa-file-pdf-o" style="font-size:84px"></i></p>
            
            <form id="sendFile" method="post" enctype="multipart/form-data" class="">
                {{csrf_field()}}
                <div class="form-group">
                  <label for="serie">Serie:</label>
                  <input type="text" class="form-control" id="serie" name="serie" placeholder="Serie del documento" >
                </div>
                <div class="form-group">
                  <label for="folio">Folio:</label>
                  <input type="text" class="form-control" id="folio" name="folio" placeholder="Folio del documento" required="">
                </div>

                <div class="form-group">
                  <label for="document">Cargar archivo</label>
                  <input type="file" class="form-control-file" id="document" name="document" required="" accept=".pdf,.zip,.rar" title="Seleccio el documento correspondiente">
                </div>

                 <button class="btn btn-danger" id="sendfile">Guardar</button>

                
              </form>

          </div>
        </div>
        
      </div>
      <div class="col md-3"></div>
    </div>
  </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
    
            <div class="modal-body text-enter"> 
              <h4 class="text-success">Espere lo estamos atendiendo</h4>
              <p></p>
              <p class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:54px"></i> </p>
                      
            </div>
    
        </div>
    </div>
</div>


@include('includes.footer')
@endsection
@section('scripts')
<script>
  jQuery(document).ready(function(){         
    
    jQuery('#sendFile').on('submit', function(e) {

      var fileInput = document.getElementById('document');
      var filePath = fileInput.value;
      var allowedExtensions = /(.pdf|.rar|.zip)$/i;
      if(!allowedExtensions.exec(filePath)){
          alert('Solo se permiten archivos PDF, Zip, RAR');
          fileInput.value = '';
          return false;
      }else{

        $("#sendfile").prop("disabled", true);
        $('#myModal').modal('show');
        e.preventDefault();

        var formData = new FormData(this);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });



        jQuery.ajax({
          url: "{{ url('companie/document') }}",
          method: 'post',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function(result){ 
            $('#myModal').modal('hide');

            jQuery('.message').html('<i class="nc-icon nc-bell-55"></i> '+result.success);

             
            jQuery('.mess').show();

             $("#sendfile").prop("disabled", false);
             $('#sendFile')[0].reset();

          },error: function(jqXHR, text, error){

            alert(jqXHR);alert(text);alert(error);
            $("#sendfile").prop("disabled", false);
            $('#myModal').modal('hide');
          }
        });

          // setTimeout(function() {
          //   jQuery('.mess').hide();
          // },3000);

          //end else
      }






    });
  });


</script>



@endsection
