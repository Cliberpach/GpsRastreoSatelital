@extends('layout')
@section('content')
@section('aplicativo-active', 'active')
@section('vehiculos-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Actualizar vehiculo</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('vehiculo.index') }}">Vehiculos</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>
                    Actualizar
                </strong>
            </li>
        </ol>
    </div>
</div>
@include('vehiculos._form')
@stop
@push('scripts')
    <script>
        $(document).ready(function() {
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            });
        });
        function consultarDocumento2() {
          
          var dnidueño = $('#dnidueño').val();
          $.ajax({
              dataType : 'json',
              type : 'POST',
              url : '{{ route('vehiculo.getDocumento') }}',
              data : {
                  '_token' : $('input[name=_token]').val(),
                  'documento' : dnidueño,
                  'id': '{{$vehiculo->id}}'
              }
          }).done(function (result){
              if (result.existe) {
                  toastr.error('El Dni ingresado ya se encuentra registrado para un vehiculo','Error');
                  clearDatosPersona(false);
              } else {
              
                      if (dnidueño.length === 8) {
                          consultarAPI(dnidueño);
                      } else {
                          toastr.error('El DNI debe de contar con 8 dígitos','Error');
                          clearDatosPersona(false);
                      }

              }
          });
      }
    </script>
@endpush