@extends('layout')
@section('content')
@section('aplicativo-active', 'active')
@section('carreras-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO CARRERA</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('carrera.index') }}">Carreras</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Registrar</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row" style="background:white;">

    <div class="col-lg-12" style="padding:0px;">
    <div id="map" style="height:800px;">
    </div>
    </div>
  </div>
  <div class="ibox " id="carrera">
     <div class="ibox-title">
         <h5>Nueva Carrera</h5> <span class="label label-primary">Agregar </span>
         <div class="ibox-tools">
             <a class="collapse-link" href="">
                 <i class="fa fa-chevron-up"></i>
             </a>
 
 
         </div>
     </div>
     <div class="ibox-content" style="">
         <div>
            <div class="form-group">
             <label class="required">Conductor</label>
             <select id="conductor" name="conductor" class="select2_form form-control {{ $errors->has('conductor') ? ' is-invalid' : '' }}">
                 <option></option>
                 @foreach(conductor() as $conductor)
                     <option value="{{ $conductor->id }}">{{ $conductor->nombre }}</option>
                 @endforeach
             </select>
            </div>
            
             <div class="form-group">
                <label class="required">Cliente</label>
                <select id="cliente" name="cliente" class="select2_form form-control {{ $errors->has('cliente') ? ' is-invalid' : '' }}">
                    <option></option>
                    @foreach(cliente_app() as $cliente)
                        <option value="{{ $cliente->user_id }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
             </div>
             <div style="text-align:left;margin-top:10px;"><label class="required" >Hora </label></div>
             <div class="input-group clockpicker" data-autoclose="true">
                 <input type="text" class="form-control" id="hora" name="hora" readonly>
                 <span class="input-group-addon">
                     <span class="fa fa-clock-o"></span>
                 </span>
             </div>
             <div class="form-group">
                 <label class="">Direccion Inicial:</label>
                     <div class="input-group">
                         <span class="input-group-addon">
                             <i class="fa fa-location-arrow"></i>
                         </span>
                         <input type="text" id="direccion_actual" name="direccion_actual"
                             class="form-control" readonly>
                     </div>
              </div>
              <div class="form-group">
                 <label class="">Direccion final:</label>
                     <div class="input-group">
                         <span class="input-group-addon">
                             <i class="fa fa-location-arrow"></i>
                         </span>
                         <input type="text" id="direccion_final" name="direccion_final"
                             class="form-control" readonly>
                             <input type="hidden" name="latinicial" id="latinicial">
                             <input type="hidden" name="lnginicial" id="lnginicial">
                     </div>
              </div>
              <div class="form-group">
                 <label class="">Importe:</label>
                     <div class="input-group">
                         <span class="input-group-addon">
                             <i class="fa fa-money"></i>
                         </span>
                         <input type="text" id="importe" name="importe"
                             class="form-control">
                             <input type="hidden" name="latfinal" id="latfinal">
                             <input type="hidden" name="lngfinal" id="lngfinal">
                     </div>
              </div>
              <div class="form-group">
                <label class="">Referencia:</label>
                    <div class="input-group">
   
                        <textarea type="text" rows="4" cols="50" id="referencia" name="referencia" 
                        ></textarea>
        
                    </div>
             </div>
              <div class="form-group">
                <button type="button" class="btn btn-primary block full-width m-b btn-margin-sesion" onclick="registrarcarrera()">actualizar</button>
              </div>
 
         </div>
     </div>
 
     <!-- Contenido del Sistema -->
     <!-- /.Contenido del Sistema -->
 <!--<div id="map" style="height:800px;">-->

 @push('styles')
 <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
 <link href="{{ asset('Inspinia/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
 <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
 
 <style>
     #carrera{
         width:300px;
         margin-right:10px;
     }
 </style>
 @endpush
 @push('scripts')
 <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
 <script src="{{ asset('Inspinia/js/plugins/clockpicker/clockpicker.js') }}" ></script>
 <script>
       var arreglo=[];
       var map;
       var polygon;
       var markers=[];
       $(document).ready(function()
         {
        
            
         
             $(".select2_form").select2({
                 placeholder: "SELECCIONAR",
                 allowClear: true,
                 height: '200px',
                 width: '100%',
             });
             $('.clockpicker').clockpicker(); 
         });
     function initMap() {
       polygon = new google.maps.Polygon();
           map = new google.maps.Map(document.getElementById("map"), {
                                   zoom: 12,
                                   center: { lat: -8.1092027, lng: -79.0244529 },
                                   gestureHandling: "greedy",
                                   draggableCursor:'default',
                                   });
          const legend = document.getElementById("carrera");
                     map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend); 
                     $("#direccion_actual").val('{{$carrera->direccionInicial}}');
          $("#direccion_final").val('{{$carrera->direccionFinal}}');
         $("#importe").val('{{$carrera->importe}}');
         $("#hora").val('{{$carrera->hora}}');
         $("#conductor").val('{{$carrera->conductor_id}}');
         $("#cliente").val('{{$carrera->user_id}}');
         $("#latinicial").val('{{$carrera->latinicial}}');
         $("#lnginicial").val('{{$carrera->lnginicial}}');
         $("#latfinal").val('{{$carrera->latfinal}}');
         $("#lngfinal").val('{{$carrera->lngfinal}}');
         $("#referencia").val('{{$carrera->referencia}}');
                     generar($("#latinicial").val(),$("#latfinal").val(),$("#lnginicial").val(),$("#lngfinal").val());         
         }
         function buscarmarker(marker)
     {   var posicion=-1;
         for(var i=0;i<markers.length;i++)
         {
             if(markers[i]===marker)
             {
                 posicion=i;
                 
             }
         }
         return posicion;
     }
     function generar(latinicial,latfinal,lnginicial,lngfinal)
     {

                     const image ={
                     scaledSize: new google.maps.Size(50, 50),
 
                     };
                   image.url =  "https://aseguroperu.com/img/e.png";
                     var marker=  new google.maps.Marker({
                        position: new google.maps.LatLng(latinicial,
                                        lnginicial),
                             map:map,
                             icon:image,
                             draggable:true,
                             });
 
                             google.maps.event.addListener(marker, 'dragend', function() {

                                      var indice=buscarmarker(this);
                                
                                      var direccion="";
                                      $.ajax({
                                        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+this.getPosition().lat()+','
                                                +this.getPosition().lng()+'&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI',  
                                           type: 'GET',
                                           async: false,
                                           success: function(res) {
                                           direccion=res.results[0].formatted_address;
                                           }
                                       });
                                       console.log(direccion);
                                         if(indice==0)
                                         {
                                             $("#direccion_actual").val(direccion);
                                             $("#latinicial").val(this.getPosition().lat());
                                             $("#lnginicial").val(this.getPosition().lng());
 
                                         }
                                         else
                                         {
                                             $("#direccion_final").val(direccion);
 
                                             $("#latfinal").val(this.getPosition().lat());
                                             $("#lngfinal").val(this.getPosition().lng());
                                         }
 
                             });
                             markers.push(marker);
                             image.url =  "https://aseguroperu.com/img/gpa_red.png";
                     var marker=  new google.maps.Marker({
                        position: new google.maps.LatLng(latfinal,
                                        lngfinal),
                             map:map,
                             icon:image,
                             draggable:true,
                             });
 
                             google.maps.event.addListener(marker, 'dragend', function() {
                                      var indice=buscarmarker(this);
                                      var direccion="";
                                      $.ajax({
                                        url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+this.getPosition().lat()+','
                                                +this.getPosition().lng()+'&key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI',  
                                           type: 'GET',
                                           async: false,
                                           success: function(res) {
                                           direccion=res.results[0].formatted_address;
                                           }
                                       });
                                         if(indice==0)
                                         {
                                             $("#direccion_actual").val(direccion);
                                             $("#latinicial").val(this.getPosition().lat());
                                             $("#lnginicial").val(this.getPosition().lng());
 
                                         }
                                         else
                                         {
                                             $("#direccion_final").val(direccion);
 
                                             $("#latfinal").val(this.getPosition().lat());
                                             $("#lngfinal").val(this.getPosition().lng());
                                         }
 
                             });
                             markers.push(marker);
                         
                    
                         
                  
        
     }
     function registrarcarrera()
     {
         var registrar=true;
         var direccionInicial=$("#direccion_actual").val();
         var direccionFinal=$("#direccion_final").val();
         var importe=$("#importe").val();
         var hora=$("#hora").val();
         var conductor_id=$("#conductor").val();
         var cliente_id=$("#cliente").val();
         var latinicial=$("#latinicial").val();
         var lnginicial=$("#lnginicial").val();
         var latfinal=$("#latfinal").val();
         var lngfinal=$("#lngfinal").val();
         var referencia=$("#referencia").val();
         if(direccionInicial.length==0||
            direccionFinal.length==0||
            hora.length==0||
            cliente_id.length==0||
            conductor_id.length==0)
            {
             toastr.error("Campo vacios","Error");
          
             registrar=false;
            }
         if(registrar)
         {
               $.ajax({
               dataType : 'json',
               type : 'POST',
               url : '{{ route('carrera.actualizar') }}',
               data : {
                   '_token' : $('input[name=_token]').val(),
                   'direccionInicial' : direccionInicial,
                   'direccionFinal' : direccionFinal,
                   'importe': importe,
                   'conductor_id': conductor_id,
                   'cliente_id': cliente_id,
                   'hora': hora,
                   'latinicial':latinicial,
                   'lnginicial':lnginicial,
                   'latfinal':latfinal,
                   'lngfinal':lngfinal,
                   'referencia':referencia,
                   'id':'{{$carrera->id}}',
                    
               }
           }).done(function (result){
             toastr.success("Registro Actualizado","Exito");
             window.location = "{{ route('carrera.index')  }}";
           });
         }
       
     }
        
   </script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&callback=initMap" async
 ></script>
 @endpush
 
@stop
