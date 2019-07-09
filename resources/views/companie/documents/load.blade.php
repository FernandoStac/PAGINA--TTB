@extends('layouts.public')
@section('title','Cargar archivos')
@section('content')

<div class="jumbotron jumbotron-fluid bg-danger">
  <div class="container-fluid">
      <h2 class="text-center text-light">Documentos</h2>
      <p class="text-center text-light">XML PDF</p>
  </div>
</div>

<div class="fix_bar"></div>

  <div class="container ">
    <div class="row">
      <div class="col md-3"></div>
        <div class="col-md-6">
          <div class="card text-white bg-dark" style="border-radius: 0">
            <div class="card-body">
              <p class="text-center"><i class="fa fa-file-pdf-o" style="font-size:34px"></i></p>
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
                  <!-- <div class="form-group">
                  <label for="grupos">Si su factura es de Grupos favor de marcar la casilla:</label>
                  <input type="checkbox" class="form-control" id="grupos" name="grupos">
                 </div> -->
                 <div class="form-group">
                  <label for="grupos">Seleccione su tipo de factura</label>
                  <select id="grupos" name="grupos" class="form-control">
                    <option selected>Grupos</option>
                    <option>Individuales</option>
                   </select>
                </div>
                  <div class="form-group">
                    <label for="document">Cargar archivo PDF</label>
                    <input type="file" class="form-control-file" id="document" name="document" required=".pdf,.rar,.zip" accept=".pdf,.rar,.zip" title="Seleccio el documento correspondiente">
                </div>

                <!-- <div class="form-group">
                    <label for="xml">Cargar archivo XML</label>
                    <input type="file" class="form-control-file" id="xml" name="xml"  accept=".xml" title="Seleccio el documento XML correspondiente">
                </div> -->

                <button class="btn btn-danger" id="sendfile">Guardar</button>
                  
              </form>
            </div>
          </div>

          <p class="text-danger">*El folio es un dato necesario</p>
          <p class="text-danger">*Archivo máximo de 10 megas</p> 
        </div>
        <div class="col md-3"></div>
      </div>
    </div>
  </div>

@include('includes.footer')
@endsection
@section('scripts')
<script>
  jQuery(document).ready(function(){         

    jQuery('#sendFile').on('submit', function(e) {
    //llamado pdf
      var fileInput = document.getElementById('document');
    //llamado xml
      var fileInputxml = document.getElementById('xml');
      var filePath = fileInput.value;
      var allowedExtensions = /(.pdf|.xml|.rar|.zip)$/i;

 
      if(!allowedExtensions.exec(filePath)){
        Swal({
              type: 'warning',
              title: 'Oops...',
              text: "Solo se permiten archivos en formato PDF, Zip, RAR, XML",
            });

          fileInput.value = '';
          fileInputxml.value = '';
        //  fileInput.value1 = '';
          return false;
      }else{

        $("#sendfile").prop("disabled", true);
        // $('#myModal').modal('show');

        Swal({
          title: 'Cargando Documento!',
          html: 'Espere por favor...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
          Swal.showLoading()
          
          }
        })
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
            Swal.close();
              Swal({
                title: result.ms,
                type: result.types,
              });

             $("#sendfile").prop("disabled", false);
             $('#sendFile')[0].reset();

          },error: function(jqXHR, text, error){
            Swal.close();

            if(error="Payload Too Large"){
              error="Documento sobrepasa los 100 Megabytes"
            }
            Swal({
              type: 'error',
              title: 'Oops...',
              text: error,
            })
            $("#sendfile").prop("disabled", false);
          }
        });
      }
    });
  });
</script>
@endsection
