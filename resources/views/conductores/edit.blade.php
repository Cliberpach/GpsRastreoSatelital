@extends('layout')
@section('content')
@section('gps-active', 'active')
@section('conductores-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Actualizar Conductor</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('conductor.index') }}">Conductores</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>
                    Actualizar
                </strong>
            </li>
        </ol>
    </div>
</div>
@include('conductores._form')
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
            var tipo_documento = $('#tipo_documento').val();
            var documento = $('#documento').val();
            // Consultamos nuestra BBDD
            $.ajax({
                dataType : 'json',
                type : 'post',
                url : '{{ route('conductor.getDocumento') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'tipo_documento' : tipo_documento,
                    'documento' : documento,
                    'id': '{{ $conductor->id }}'
                }
            }).done(function (result){
                if (result.existe) {
                    if (!result.igual_persona) {
                        toastr.error('El '+ tipo_documento +' ingresado ya se encuentra registrado para un conductor','Error');
                    }else{
                        if (tipo_documento === "DNI") {
                            if (documento.length === 8) {
                                consultarAPI(tipo_documento, documento);
                            } else {
                                toastr.error('El DNI debe de contar con 8 dígitos','Error');
                            }
                        } else if (tipo_documento === "RUC") {
                            if (documento.length === 11) {
                                consultarAPI(tipo_documento, documento);
                            } else {
                                toastr.error('El RUC debe de contar con 11 dígitos','Error');
                            }
                        }
                    }
                } else {
                    if (tipo_documento === "DNI") {
                        if (documento.length === 8) {
                            consultarAPI(tipo_documento, documento);
                        } else {
                            toastr.error('El DNI debe de contar con 8 dígitos','Error');
                        }
                    } else if (tipo_documento === "RUC") {
                        if (documento.length === 11) {
                            consultarAPI(tipo_documento, documento);
                        } else {
                            toastr.error('El RUC debe de contar con 11 dígitos','Error');
                        }
                    }
                }
            });
        }
    </script>
@endpush