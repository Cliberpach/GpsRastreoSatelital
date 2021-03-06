@extends('layout')
@section('content')
@section('gps-aplicativo', 'active')
@section('consulta-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Consulta</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Consulta de Carrera</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                          <div class="row">
        
                              <div class="col-lg-12">
                                <div class="card text-center">
                                    <div class="card-header bg-primary">
                                      Alertas
                                    </div>
                                    <div class="card-body">
                                        <div class="panel-body">
                                            <div class="form-group row">
                                               <div class="col-lg-4"> <div id="map" style="height:300px;">
                                                 </div>
                                               </div>
                                               <div class="col-lg-8">
                                                  <div class="form-group row">
                                                  <div class="col-lg-3 col-xs-12">
                                               
                                                    <div style="text-align:left;"><label class="required" >Fecha de Inicio</label></div>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" id="fecha" name="fecha"  class="form-control"  >
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Hora Inicio</label></div>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" id="hinicio" name="hinicio">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Hora final</label></div>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" id="hfinal" name="hfinal" >
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Conductor</label></div>
                                                    <select class="select2_form form-control" style="text-transform: uppercase; width:100%" name="conductor" id="conductor" >
                                                        <option></option>
                                                        @foreach (Conductores() as $conductor)
                                                        <option value="{{$conductor->id}}" >{{$conductor->nombre}}</option>
                                                        @endforeach
                                                     </select>
                                                </div>
                                                <div class="col-lg-3 col-xs-12">
                                                    <div style="text-align:left;"><label class="required" >Cliente</label></div>
                                                    <select class="select2_form form-control" style="text-transform: uppercase; width:100%" name="cliente" id="cliente" >
                                                        <option></option>
                                                        @foreach (cliente_app() as $cliente)
                                                        <option value="{{$cliente->id}}" >{{$cliente->nombre}}</option>
                                                        @endforeach
                                                     </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button id="btn_reporte" class="btn btn-block btn-w-m btn-primary m-t-md" onclick="consultar()">
                                                        <i class="fa fa-plus-square"></i>Consultar
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <form action="{{route('carrera.consultarcarreraspdf')}}" method="POST" id="frm_pdf">
                                                        @csrf
                                                            <button  type="button" id="btn_reporte_pdf" class="btn btn-block btn-w-m btn-primary m-t-md" onclick="descargarpdf()">
                                                                    <i class="fa fa-file-pdf-o"></i>PDF
                                                                </button>
                                                                <input type="hidden" id="arreglo_reporte" name="arreglo_reporte">
                                                                <input type="hidden" id="fecha_reporte" name="fecha_reporte">
                                                                <input type="hidden" id="hinicio_reporte" name="hinicio_reporte">
                                                                <input type="hidden" id="hfinal_reporte" name="hfinal_reporte">
                                                                <input type="hidden" id="alerta_reporte" name="alerta_reporte">
                                                                <input type="hidden" id="dispositivo_reporte" name="dispositivo_reporte">
                                 
                                                    </form>
                                                 
                                                   
                                                </div>
                                                <div class="col-lg-3">
                                                <div  id="cargando"></div>
                                                </div>
                                                  </div>
                                               </div>
                                            
                                                
                                               <!-- <div class="col-lg-3">
                                                    <button id="btn_reporte" class="btn btn-block btn-w-m btn-primary m-t-md">
                                                        <i class="fa fa-plus-square"></i>Exportar
                                                    </button>
                                                </div>-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table dataTables-reporte table-striped table-bordered table-hover"  style="text-transform:uppercase">
                                                    <thead>
                                                        <tr> 
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                             <th class="text-center">PLACA</th>
                                                             <th class="text-center">ORIGEN</th>
                                                             <th class="text-center">DESTINO</th>
                                                             <th class="text-center">PUNTUACION</th>
                                                             <th class="text-center">ESTADO</th>
							                                 <th>Opciones</th>
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
			 @csrf
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('styles')
    <!-- DataTable -->
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <style>
            .loader {
        border: 13px solid #f3f3f3;
        border-radius: 50%;
        border-top: 13px solid #3498db;
        margin:20px 0px 0px 0px;
        width: 40px;
        height: 40px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }
        .checked {
  color: orange;
}
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- DataTable -->
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('Inspinia/js/plugins/clockpicker/clockpicker.js') }}" ></script>
    <script>
        var map;   
	var markers=[];
    var markers_ruta=[];
    var datos=[];
    var pdf=[];
    function descargarpdf()
    {
        if(pdf.length==0)
        {
            toastr.error('No hay datos para generar reporte','Error');
        }
        else{
             $('#arreglo_reporte').val(JSON.stringify(pdf));
            $('#fecha_reporte').val($('#fecha').val());
            $('#hinicio_reporte').val($('#hinicio').val());
            $('#hfinal_reporte').val($('#hfinal').val());
            $('#alerta_reporte').val($('#alerta').val());
            $('#dispositivo_reporte').val($('#dispositivo').val());
            document.getElementById('frm_pdf').submit();


        }
    }
         function initMap() {
                  map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: { lat: -8.1092027, lng: -79.0244529 },
                gestureHandling: "greedy",
                mapTypeControl: false,
                fullscreenControl: false
            });

         }
           $(document).ready(function() {
                $(".select2_form").select2({
                    placeholder: "SELECCIONAR",
                    allowClear: true,
                    height: '200px',
                    width: '100%',
                });
                $('.input-group.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    language: 'es',
                    format: "yyyy/mm/dd"
                });
                $('.clockpicker').clockpicker();
                $('.dataTables-reporte').DataTable({
                    "dom": '<"html5buttons"B>lTfgitp',
                "buttons": [
                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i> Excel',
                        titleAttr: 'Excel',
                        title: 'Reporte de Alertas',
                                exportOptions: {
                            columns: [ 2, 3,4,6,7,8 ]
                            
                        }
                    },
                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i> Pdf',
                        titleAttr: 'PdF',
                        title: 'Reporte de Alertas' ,    exportOptions: {
                            columns:  [ 2, 3,4,6,7,8 ]
                        }
                    } 
                ],
                "bPaginate": true,
                "bLengthChange": true,
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },
		            {
                        "targets": [1],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [2],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [3],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [4],
                    },
                    {
                        "targets": [5],
                    },
                    {
                        "targets": [6],
                    },
                    {
                        searchable: false,
                        "targets": [7],
                        data: null,
                        render: function(data, type, row) {
                           
                           var data=data[7] == "Sin puntuacion" ? 0:data[7];
                           var html=" ";
                           for(i=0;i<5;i++)
                           {
                               if(i<data)
                               {
                                 html=html+"<span class='fa fa-star checked'></span>";   
                               }
                               else{
                                html=html+"<span class='fa fa-star'></span>";   
                               }
                              
                           }
                        
                             return  html;
                        }
                    },
                    {
                        "targets": [8],
                    },

                    {
                        searchable: false,
                        "targets": [9],
                        data: null,
                        render: function(data, type, row) {
                           
                             return  "<div class='btn-group'>" +
                                        "<a class='btn btn-sm btn-warning btn-ubicacion' style='color:white'>"+ "<i class='fa fa-location-arrow'></i>"+"</a>" +
                                        "</div>";
                        }
                    },
                ],
                'bAutoWidth': false,
                'aoColumns': [
                    { sWidth: '0%' },
                    { sWidth: '0%' },
                    { sWidth: '0%' },
                    { sWidth: '0%' },
                    { sWidth: '30%', sClass: 'text-center' },
                    { sWidth: '30%', sClass: 'text-center' },
                    { sWidth: '30%', sClass: 'text-center' },
                    { sWidth: '10%', sClass: 'text-center' },
                    { sWidth: '10%', sClass: 'text-center' },
		            { sWidth: '0%' },  
              ],
                "language": {
                    url: "{{asset('Spanish.json')}}"
                },
                "order": [[ 0, "desc" ]],
            });
            });
         function consultar()
         {
            var enviar=true;
            var fecha = $("#fecha").val();
            var hinicio = $("#hinicio").val();
            var hfinal = $("#hfinal").val();
            var conductor=$("#conductor").val();
            var cliente=$("#cliente").val();
            if(conductor.length===0)
            {
                conductor=" ";
            }
            if(cliente.length===0)
            {
                cliente=" ";
            }

            var fechainicio=" ";
            var fechafinal=" ";

            if(fecha.length!=0 || hinicio.length!=0 || hfinal.length!=0)
            {
                        if (fecha.length === 0
                    || hinicio.length === 0
                    || hfinal.length === 0 
                    || dispositivo.length === 0) {
                        toastr.error('Complete la informaci??n de los campos obligatorios (*)','Error');
                        enviar= false;
                    }
                    var fecha1 = new Date('1/1/1990 '+hinicio);
                    var fecha2 = new Date('1/1/1990 '+hfinal);
                    fechainicio=fecha+" "+hinicio;
                    fechafinal=fecha+" "+hfinal;
                    if(fecha1 > fecha2)
                    {
                        toastr.error('Error de fechas','Error');
                        enviar=false;
                    }
            }
            
           
            if(enviar)
            {

                data(conductor,fechainicio,fechafinal,cliente,function (returnValue){
                    console.log(returnValue);
                 var t = $('.dataTables-reporte').DataTable();
                                    t.clear().draw();
                                for(var i=0;i<returnValue.length;i++)
                                {
                                   
                                    t.row.add([
                                        returnValue[i].latinicial,
                                        returnValue[i].lnginicial,
                                        returnValue[i].latfinal,
                                        returnValue[i].lngfinal,
                                        returnValue[i].placa,
                                        returnValue[i].direccionInicial,
                                        returnValue[i].direccionFinal,
                                        returnValue[i].puntuacion,
                                        returnValue[i].estadocarrera,
                                            '',
                                        ]).draw(false);
                                        var fila={"placa":returnValue[i].placa,
                                        "direccionInicial":returnValue[i].direccionInicial,
                                        "direccionFinal":returnValue[i].direccionFinal,
                                        "puntuacion":returnValue[i].puntuacion,
                                        "estadoCarrera":returnValue[i].estadoCarrera};
                                         pdf.push(fila);
                                        if((i+1)==returnValue.length)
                                        {
                                            $("#cargando").removeClass("loader");
                                        }
                                }
                            
                });
            }
         }
         $(document).on('click', '.btn-ubicacion', function(event) {
                        setMapOnAll(null);
                    var table = $('.dataTables-reporte').DataTable();
                        var data = table.row($(this).parents('tr')).data();
                    const image ={
                                url:"https://aseguroperu.com/img/e.png",
                                // This marker is 20 pixels wide by 32 pixels high.
                                scaledSize: new google.maps.Size(50, 50),
                                // The origin for this image is (0, 0).
                                };
                    var marker = new google.maps.Marker({ position: new google.maps.LatLng(data[0],
                    data[1]),
                    map: map,
                    icon: image,
                    });
                    markers.push(marker);
                    marker.setMap(map);
                    const image1 ={
                                url:"https://aseguroperu.com/img/gpa_red.png",
                                // This marker is 20 pixels wide by 32 pixels high.
                                scaledSize: new google.maps.Size(50, 50),
                                // The origin for this image is (0, 0).
                                };
                    var marker1 = new google.maps.Marker({ position: new google.maps.LatLng(data[2],
                    data[3]),
                    map: map,
                    icon: image1,
                    });
                    markers.push(marker1);
                    map.setZoom(15);
                    centrar();

            });
	 function data(conductor,fechainicio,fechafinal,cliente,datos)
	 {
        $("#cargando").addClass("loader");
        $.ajax({
                        dataType : 'json',
                        type : 'POST',
                        timeout: 7200000,
                        url : '{{ route('carrera.consultarcarreras') }}',
                        data : {
                            '_token' : $('input[name=_token]').val(),
                            'conductor': conductor,
                            'fechainicio': fechainicio,
                            'fechafinal' : fechafinal,
                            'cliente':cliente				
                        },
                        success: datos
                    });
	 }
     function degree_to_decimal(coordinates_in_degrees, direction)
{
    degrees = (coordinates_in_degrees / 100);
    minutes = coordinates_in_degrees - (degrees * 100);
    seconds = minutes / 60;
    coordinates_in_decimal = degrees + seconds;
    if ((direction == "S") || (direction == "W")) {
        coordinates_in_decimal = coordinates_in_decimal * (-1);
    }
    return coordinates_in_decimal;
}
function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        function centrar()
    {
        var bounds = new google.maps.LatLngBounds();
                for (i = 0; i < markers.length; i++) {
                bounds.extend(markers[i].getPosition());
                }
                map.setCenter({lat: bounds.getCenter().lat(), lng: bounds.getCenter().lng()});
    }
	
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&callback=initMap" async
    ></script>
@endpush
