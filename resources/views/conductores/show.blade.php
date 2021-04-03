@extends('layout')
@section('content')
@section('aplicativo-active', 'active')
@section('conductor-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Datos del Conductor: {{ $conductor->nombre }}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('conductor.index') }}">Conductores</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Datos</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div>
                        <a href="{{ route('conductor.edit', $conductor->id) }}" class="btn btn-warning btn-xs float-right">
                            <i class="fa fa-edit"></i>EDITAR CONDUCTOR
                        </a>
                       <h2  style="text-transform:uppercase">{{ $conductor->nombre }}</h2>
                    </div>
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-personales"> DATOS DEL CONDUCTOR  </a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-personales2"> DATOS DEL CONDUCTOR </a></li>
                        
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-personales" class="tab-pane active">
                                <div class="panel-body">
                                    <h4><b><i class="fa fa-caret-right"></i> DATOS DEL Conductor</b></h4><br>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>TIPO DE DOCUMENTO</strong></label>
                                            <p>{{ $conductor->tipo_documento }}</p>
                                        </div>
                                        <div class="form-group col-lg-3 col-xs-12">
                                            <label><strong>DOCUMENTO</strong></label>
                                            <p>{{ $conductor->documento }}</p>
                                        </div>
                                        <div class="form-group col-lg-2 col-xs-12">
                                            <label><strong>ESTADO</strong></label>
                                            <p>{{ ($conductor->activo == 1) ? 'ACTIVO' : 'INACTIVO' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>NOMBRE</strong></label>
                                            <p>{{ $conductor->nombre }}</p>
                                        </div>
                                       
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>DIRECCION</strong></label>
                                            <p>{{ $conductor->direccion }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>TELÉFONO MÓVIL</strong></label>
                                            <p>{{ $conductor->telefono_movil }}</p>
                                        </div>
                                        <div class="form-group col-lg-4 col-xs-12">
                                            <label><strong>CORREO ELECTRÓNICO</strong></label>
                                            <p>{{ ($conductor->correo_electronico) ? $conductor->correo_electronico : '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-personales2" class="tab-pane">
                                <div class="panel-body">
                                    <h4><b><i class="fa fa-caret-right"></i> DATOS DEL Conductor</b></h4><br>
                                    <div class="row">
                                            <div class="col-md-6">
                                            <h4><b><i class="fa fa-caret-right"></i> Datos del Contacto</b></h4><br>
                                            <div class="row">
                                                <div class="form-group col-lg-4 col-xs-12">
                                                    <label><strong>TIPO DE DOCUMENTO CONTACTO</strong></label>
                                                    @if($conductor->tipo_documento_contacto != "")
                                                    <p>{{$conductor->tipo_documento_contacto}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                                <div class="form-group col-lg-3 col-xs-12">
                                                    <label><strong>DOCUMENTO CONTACTO</strong></label>
                                                      @if($conductor->documento_contacto != "")
                                                            <p>{{$conductor->documento_contacto}}</p>
                                                        @else
                                                            <p>-</p>
                                                        @endif
                                                </div>
                                                <div class="form-group col-lg-2 col-xs-12">
                                                    <label><strong>NOMBRE CONTACTO</strong></label>
                                                    @if($conductor->nombre_contacto != "")
                                                    <p>{{$conductor->nombre_contacto}}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>

                        </div>
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
    <!-- iCheck -->
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
@endpush