@extends('layout')
@section('content')
@section('aplicativo-active', 'active')
@section('conductores-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Listado de conductores</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>conductores</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2 col-md-2">
        <button id="btn_añadir_conductor" class="btn btn-block btn-w-m btn-primary m-t-md">
            <i class="fa fa-plus-square"></i> Añadir nuevo
        </button>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table dataTables-conductor table-striped table-bordered table-hover"  style="text-transform:uppercase">
                            <thead>
                            <tr>
                                <th class="text-center">CONDUCTOR</th>
                                <th class="text-center">NOMBRE</th>
                                <th class="text-center">DIRECCION</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('styles')
    <!-- DataTable -->
    <link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <!-- DataTable -->
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            // DataTables
            $('.dataTables-conductor').DataTable({
                "dom": '<"html5buttons"B>lTfgitp',
                "buttons": [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'conductors'
                    },
                    {
                        titleAttr: 'Imprimir',
                        extend: 'print',
                        text:      '<i class="fa fa-print"></i> Imprimir',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    } 
                ],
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bInfo": true,
                "bAutoWidth": false,
                "processing":true,
                "ajax": "{{ route('conductor.getTable')}}",
                "columns": [
                    {data: 'tipo_documento', className:"text-center"},
                    {data: 'nombre', className:"text-left"},
                    {data: 'direccion', className:"text-center"},
                    {
                        data: null,
                        className:"text-center",
                        render: function(data) {
                            //Ruta Detalle
                            var url_editar = '{{ route("conductor.edit", ":id")}}';
                            url_editar = url_editar.replace(':id',data.id);
                            //Ruta Tiendas
                            return "<div class='btn-group'>" +
                                "<a class='btn btn-warning btn-sm modificarDetalle' href='"+url_editar+"' title='Modificar'><i class='fa fa-edit'></i></a>" +
                                "</div>";
                        }
                    }
                ],
                "language": {
                    "url": "{{asset('Spanish.json')}}"
                },
                "order": [],
            });
            // Eventos
            $('#btn_añadir_conductor').on('click', añadirconductor);
        });
        //Controlar Error
        $.fn.DataTable.ext.errMode = 'throw';
        //Modal Eliminar
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        }) 
        // Funciones de Eventos
        function editarconductor(url) {
            window.location = url;
        }
    </script>
@endpush
