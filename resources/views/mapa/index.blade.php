@extends('layout')
 @section('content')
 <div class="row" style="background:white;">
   <div class="col-lg-3" style="padding:10px;">
    <div style="margin:10px;">
	<div  class="input-group">
      <input class="form-control" id="myInput" type="text" placeholder="Search..">
         <span class="input-group-append"><a style="color:white;cursor:pointer;"; class="btn btn-primary"><i class="fa fa-search"></i></a></span>
	</div>	
</div>
   <div style="height:700px!important;" class="contenedor">
    <table class="table table-bordered" style="border-spacing: 10px;border-collapse: separate;" >
      <thead>
		</thead>
   <tbody id="myTable" >
   @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
	@foreach (dispositivo_user(auth()->user()) as $dispositivo)
     <tr  id="td_{{$dispositivo->imei}}" onclick="zoom(this)" data-imei="{{$dispositivo->imei}}" > 
                  <td  ><div class="row"  >
                    <div class="col-lg-4">
                        <i class="fa fa-car fa-3x circle" style="color:rgb(00, 00, 00);" aria-hidden="true">
                          </i>
                      </div>
                    <div class="col-lg-8">
                    <div id="estado_gps">
                    @if(find_dispositivo($dispositivo->imei))
                            
                            <div class="circle_gps button" id="button-0">
                              </div>
                              <input type="hidden" name="estado_dispositivo" id="estado_dispositivo" value="Conectado">
                            
                            
                              @else 
                              <div class="circle_gps_red button" id="button-0"></div>
                              <input type="hidden" name="estado_dispositivo" id="estado_dispositivo" value="Desconectado">
                        @endif
                    </div> 
                     
                  <div id="movimiento_gps">
                  @if(find_dispositivo_movimiento($dispositivo->imei))
                  <img src="img/car-side.svg" class="filter-green" width="25px" id="button-0" style="top:40px!important;position: absolute;left:142px;"/>
                 <!-- <div  class="circle_gps_blue button" id="button-0" style="top:40px!important;">
                              </div>-->
                  @else
                  <img src="img/car-side_two.svg" class="filter-green" width="25px" id="button-0" style="top:40px!important;position: absolute;left:142px;"/>
                  <!-- <div  class="circle_gps_yellow button" id="button-0" style="top:40px!important;">
                              </div>-->
                  @endif
                    
                  </div>

                      <b>Placa:</b>{{$dispositivo->placa}} <br>
                      <b>Marca:</b>{{$dispositivo->marca}} <br>
                      <b>Color:</b>{{$dispositivo->color}} <br>
                    </div>
                  </div></td>
        </tr>
 
        
        @endforeach  
        @endif      
      </tbody>
    </table>
</div>
   </div>
   <div class="col-lg-9" style="padding:0px;">
   <div id="map" style="height:800px;">
   </div>
      <div id="legend" style="width:400px;heigth:200px;border:solid;background:white;margin:20px;border-radius: 10px;padding:10px;">
       <div style="text-align: center;"><h3>Leyenda</h3></div> 
            <div class="row">
                 <div class="col-lg-6">
                  <div class="row">
                        <div class="col-lg-3">
                          <h4 >Conectado</h4>
                        </div>
                        <div class="col-lg-9" >
                          <div class="circle_gps button" id="button-0">
                          </div>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-lg-3">
                          <h4 >Desconectado</h4>
                        </div>
                        <div class="col-lg-9" >
                        <div class="circle_gps_red button" id="button-0">
                              </div>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-lg-3">
                          <h4 >Movimiento</h4>
                        </div>
                      <div class="col-lg-9" >
                      <img src="img/car-side.svg" class="filter-green" width="25px" id="button-0" style="position: absolute;left:110px;"/>
                      </div>
                  </div>
                  <div class="row">
                        <div class="col-lg-4">
                          <h4 >Sin Movimiento</h4>
                        </div>
                      <div class="col-lg-8" >
                      <img src="img/car-side_two.svg" class="filter-green" width="25px" id="button-0" style="position: absolute;left:95px;"/>
                      </div>
                  </div>
                  </div>
                  <div class="col-lg-6">
                  @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
                  <div id="activo_inactivo">
                    <h4 >N° en Movimiento:{{dispositivo_activos(auth()->user())}}</h4>
                    <h4 >N° sin Movimiento:{{dispositivo_inactivos(auth()->user())}}</h4>
                  </div>
                  
                  @endif
                  </div>
                 </div>

                 
                 
            
           
      
      </div>
   </div>
 </div>
@if(is_array(rangos()) || is_object(rangos()))
    <input type="hidden" name="posiciones_gps" id="posiciones_gps" value="{{rangos()}}">
@endif
    <!-- Contenido del Sistema -->
    <!-- /.Contenido del Sistema -->
<!--<div id="map" style="height:800px;">-->
@stop
@push('styles-mapas')
<style>
.circle {
  display: inline-block;
  border-radius: 60px;
  box-shadow: 0px 0px 2px #888;
  padding: 0.3em 0.3em;
}

.circle_gps {
  width: 10px;
  height: 10px;
  background: green;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
  position: absolute;
}


.circle_gps::before, .circle_gps::after {
  content:"";
  position:absolute;
  top: 50%;
  left: 50%;
  transform:translate(-50%, -50%);
  width: 70px;
  height: 70px;
  border: 10px solid gray;
  border-radius:100%;
  animation: latido linear 3s infinite;
}
.circle_gps::before, .circle_gps::after {
  animation: latido linear 3s infinite;
}

.circle_gps::after {
  animation-delay: -1.5s;
}

@keyframes latido {
  0% { width:15px; height:15px; border:5px solid rgb(49,222, 5); }
  100% { width:30px; height:30px; border:5px solid transparent; }
}


.circle_gps {
  width: 10px;
  height: 10px;
  background: green;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
  position: absolute;
}

.circle_gps::before, .circle_gps::after {
  content:"";
  position:absolute;
  top: 50%;
  left: 50%;
  transform:translate(-50%, -50%);
  width: 70px;
  height: 70px;
  border: 10px solid gray;
  border-radius:100%;
  animation: latido linear 3s infinite;
}
.circle_gps::before, .circle_gps::after {
  animation: latido linear 3s infinite;
}

.circle_gps::after {
  animation-delay: -1.5s;
}

@keyframes latido {
  0% { width:15px; height:15px; border:5px solid rgb(49,222, 5); }
  100% { width:30px; height:30px; border:5px solid transparent; }
}



.circle_gps_red {
  width: 10px;
  height: 10px;
  background: red;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 50px;
  position: absolute;
}

.circle_gps_red::before, .circle_gps_red::after {
  content:"";
  position:absolute;
  top: 50%;
  left: 50%;
  transform:translate(-50%, -50%);
  width: 70px;
  height: 70px;
  border: 10px solid gray;
  border-radius:100%;
  animation: latido_red linear 3s infinite;
}
.circle_gps_red::before, .circle_gps_red::after {
  animation: latido_red linear 3s infinite;
}

.circle_gps_red::after {
  animation-delay: -1.5s;
}

@keyframes latido_red {
  0% { width:15px; height:15px; border:5px solid rgb(222,49, 5); }
  100% { width:30px; height:30px; border:5px solid transparent; }
}


#button-0 { top: 10px; right: 28px; }
</style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@endpush
@push('scripts-mapas')
<script>
      var arreglo=[];
      var map;
      var polygon;
      
    function initMap() {
      polygon = new google.maps.Polygon();
          map = new google.maps.Map(document.getElementById("map"), {
                                  zoom: 12,
                                  center: { lat: -8.1092027, lng: -79.0244529 },
                                  gestureHandling: "greedy",
                                  });
      const legend = document.getElementById("legend");
      map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend);
	    const image ={
                    url:"https://aseguroperu.com/img/e.png",
                    // This marker is 20 pixels wide by 32 pixels high.
                    scaledSize: new google.maps.Size(50, 50),
                    // The origin for this image is (0, 0).
                    };
                    @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
	@foreach (dispositivogps_user(auth()->user()) as $dispositivo)
	  var cadena='{{$dispositivo->cadena}}';
	  var velocidad = cadena.split(',');
    var mph=(parseFloat(velocidad[11])*1.15078)*1.61;
	  var geocoder=new google.maps.Geocoder();
  	var marker = new google.maps.Marker({ position: new google.maps.LatLng({{$dispositivo->lat}},
                                        {{$dispositivo->lng}}),
                                        map: map,
                                        icon: image,
                                        title: '{{$dispositivo->placa}}'
                                        });
        marker.setMap(map);
	  var direccion="Sin direccion";
	  var markerposition=marker.getPosition();
	  geocoder.geocode({'latLng':markerposition},function(results,status){
                      if(status==google.maps.GeocoderStatus.OK)
                      {
                      if(results){
                        direccion=results[0].formatted_address;
                        }
                      }
                    });
google.maps.event.clearInstanceListeners(marker);
		google.maps.event.addListener(marker, 'click', function() {
      var contentString = '<div>Placa:'+'{{$dispositivo->placa}}'+'<br>Marca:'+'{{$dispositivo->marca}}'+'<br>Color:{{$dispositivo->color}}'+'<br>Velocidad:'+mph+'<br>Direccion:'+direccion+'</div>';
          var infowindow = new google.maps.InfoWindow({
                                                  content: contentString,
                                                  width:192,
                                                  height:100
                                               });
                                            infowindow.open(map,this);
  },false);
           arreglo.push({'lat':{{$dispositivo->lat}},'lng':{{$dispositivo->lng}},'imei':{{$dispositivo->imei}},'marker':marker,'marca':'{{$dispositivo->marca}}','color':'{{$dispositivo->color}}','placa':'{{$dispositivo->placa}}','direccion':direccion,'velocidad':velocidad });
        @endforeach	
        generar();
        @endif
	}
  function generar()
  {
    if($('#posiciones_gps')!=undefined)
          {
                  var detalle=JSON.parse($("#posiciones_gps").val());
                  var areaCoordinates=[];
                for(var i=0;i<detalle.length;i++)
                {
                  var arreglo=[];
                  arreglo.push(detalle[i].lat);
                  arreglo.push(detalle[i].lng);
                  areaCoordinates.push(arreglo);
                }
                var pointCount = areaCoordinates.length;
                var areaPath = [];
                for (var i=0; i < pointCount; i++) {
                    var tempLatLng = new google.maps.LatLng(
                    areaCoordinates[i][0] , areaCoordinates[i][1]);
                    areaPath.push(tempLatLng);
                }
                var polygonOptions = 
                {
                    paths: areaPath,
                    strokeColor: '#FFFF00',
                    strokeOpacity: 0.9,
                    strokeWeight: 1,
                    fillColor: '#FFFF00',
                    fillOpacity: 0.20
                }
                
                polygon.setOptions(polygonOptions);
                polygon.setMap(map);
          }
  }
  @if(is_array(dispositivo_user(auth()->user())) || is_object(dispositivo_user(auth()->user())))
        setInterval(dispositivo, 10000);
       setInterval(dispositivo_estado, 10000);
       setInterval(dispositivo_Movimiento, 10000);
  @endif
        function dispositivo_Movimiento()
        {
          $.ajax({
                dataType : 'json',
                type     : 'POST', 
                url      : '{{ route('gpsmovimiento') }}',
                data : {
                  '_token' : $('input[name=_token]').val()
                  }
               
            }).done(function (result){
              //console.log(result);
              $("#activo_inactivo").html("<h4 >N° en Movimiento:"+result.activos+"</h4>"+"<h4 >N° sin Movimiento:"+result.inactivos+"</h4>");

            });
        }
        function dispositivo_estado()
        {
          $.ajax({
                dataType : 'json',
                type     : 'POST',
                url      : '{{ route('gpsestado') }}'
            }).done(function (result){
              for(var i=0;i<result.length;i++)
              {
                if(result[i].estado=="Conectado")
                {
                  $('#td_'+result[i].imei+' #estado_gps').html('<div class="circle_gps button" id="button-0"> </div><input type="hidden" name="estado_dispositivo" id="estado_dispositivo" value="Conectado">');
                }
                else
                {
                  $('#td_'+result[i].imei+' #estado_gps').html('<div class="circle_gps_red button" id="button-0"> </div><input type="hidden" name="estado_dispositivo" id="estado_dispositivo" value="Desconectado">');
                 
                }
                if(result[i].movimiento=="Movimiento")
                {
                  $('#td_'+result[i].imei+' #movimiento_gps').html(' <img src="img/car-side.svg" class="filter-green" width="25px" id="button-0" style="top:40px!important;position: absolute;left:142px;"/> ');
                }
                else
                {
                  $('#td_'+result[i].imei+' #movimiento_gps').html(' <img src="img/car-side_two.svg" class="filter-green" width="25px" id="button-0" style="top:40px!important;position: absolute;left:142px;"/> ');
                }
               
              }
            });
        }
 	 //dispositivo();
	 function dispositivo()
       {
          $.ajax({
                dataType : 'json',
                type     : 'POST',
                url      : '{{ route('gps') }}'
            }).done(function (result){
	
		var i=0;	
		for(i=0;i<result.length;i++)
		{
	           var latlng = new google.maps.LatLng(result[i].lat,result[i].lng);
                   var indice=buscar(arreglo,parseInt(result[i].imei));
		   var cadena=result[i].cadena;
		   var velocidad = cadena.split(',');
        		var mph=(parseFloat(velocidad[11])*1.15078)*1.61;
	   	          arreglo[indice].marker.setPosition(latlng);
		         var placa=result[i].placa;
			  var  marca=result[i].marca;
		          var  modelo=result[i].modelo;
               arreglo[indice].placa=placa;
	       arreglo[indice].marca=marca;
	       arreglo[indice].color=result[i].color;
	       arreglo[indice].velocidad=mph;
	       arreglo[indice].lat=result[i].lat;
	       arreglo[indice].lng=result[i].lng;
                        google.maps.event.clearInstanceListeners(arreglo[indice].marker);
			google.maps.event.addListener(arreglo[indice].marker, 'click', function() {
                        var  nindice=buscarmarker(this)
				 var direccion="Sin direccion";
          	var  geocoder=new google.maps.Geocoder();
		var markerposition={
    lat: parseFloat(arreglo[nindice].lat),
    lng: parseFloat(arreglo[nindice].lng),
  };
console.log(markerposition);
          geocoder.geocode({'latLng':markerposition},function(results,status){
                if(status===google.maps.GeocoderStatus.OK)
                {
                 if(results){
                        arreglo[nindice].direccion=results[0].formatted_address;
        		//console.log("si lo encontro"+arreglo[nindice].imei);
			 }
			else 
			{
				console.log("no se  encontro");
			}
                }
		else 
		{
		  console.log("fallo al buscar");
		}
		});
      var contentString = '<div>Placa:'+arreglo[nindice].placa+'<br>Marca:'+arreglo[nindice].marca+'<br>Color:'+arreglo[nindice].color+'<br>velocidad:'+arreglo[nindice].velocidad+'<br>Direccion:'+arreglo[nindice].direccion+'</div>'
          var infowindow = new google.maps.InfoWindow({
                                                  content: contentString,
                                                  width:192,
                                                  height:100
                                               });
                                            infowindow.open(map,this);
  },false);
                   //console.log('imei'+result[i].imei+' posicion:'+indice);
		}
            });
       }
function buscarmarker(marker)
{
          var position=-1;
          var i=0;
          for( i=0;i<arreglo.length;i++)
          {
              if(_.isEqual(marker, arreglo[i].marker))
              {
                position=i;
              //  break;
              }
          }
          return position;
}
function buscar(data,elemento)
        {
          var position=-1;
          var i=0;
          for( i=0;i<data.length;i++)
          {
              if(data[i].imei===elemento)
              {
                position=i;
              //  break;
              }
          }
          return position;
        }
 	$("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
        function zoom(e){
          var existe;
          var imei=$(e).data('imei');
          $.ajax({
                dataType : 'json',
                type     : 'POST',
                async    : false,
                url      : '{{ route('verificardispositivo') }}',
                data : {
                  '_token' : $('input[name=_token]').val(),
                  'imei' : imei
              }
            }).done(function (result){
              existe=result.existe;
            });
           var conexion= $('#td_'+imei+' #estado_dispositivo').val();
           console.log(conexion);
         if(conexion=="Conectado")
         {
           console.log("ddd");
                if(existe)
              {
                var indice=buscar(arreglo,parseInt($(e).data('imei')));
                var posicion=arreglo[indice].marker.getPosition();
              //  myLatlng = { lat: parseFloat($(e).data('lat')), lng: parseFloat($(e).data('lng'))};
                map.setZoom(16);
                map.setCenter(posicion)
              }
              else
              {
                toastr.warning('El dispositivo se encuentra conectado pero su ubicacion estan en blanco', 'Mensaje');
              }
         }
       
        /*var indice=buscar(arreglo,parseInt($(e).data('imei')));
		    var posicion=arreglo[indice].marker.getPosition();
        //  myLatlng = { lat: parseFloat($(e).data('lat')), lng: parseFloat($(e).data('lng'))};
          map.setZoom(16);
          map.setCenter(posicion);*/
        }
  </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6qv64RYCHFJOygheJS7DvBDYB0iV2wI&callback=initMap" async
></script>
@endpush
