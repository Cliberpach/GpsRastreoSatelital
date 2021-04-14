<div class="wrapper wrapper-content animated fadeIn" id="contenedor" >
    <form class="wizard-big formulario" action="{{ $action }}" method="POST" id="form_registrar_vehiculo">
        @csrf
        <h1>Datos Del Vehiculo</h1>
        <fieldset  style="position: relative;">
            <div class="row">
                <div class="col-md-12 b-r">
                    <div class="form-group row">
                        <div class="col-lg-4 col-xs-12">
                            <label class="required">Dni</label>
                            <div class="input-group">
                                <input type="text" id="dnidueño" name="dnidueño" class="form-control {{ $errors->has('dnidueño') ? ' is-invalid' : '' }}" value="{{old('dnidueño')?old('dnidueño'):$vehiculo->dnidueño}}"  onkeypress="return isNumber(event)" required maxlength="25">
                                <span class="input-group-append"><a style="color:white"@if($vehiculo->estado != '') onclick="consultarDocumento2()" @else onclick="consultarDocumento()" @endif  class="btn btn-primary"><i class="fa fa-search"></i> <span id="entidad">Entidad</span></a></span>
                                @if ($errors->has('dnidueño'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dnidueño') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <label class="required">Propietario</label>
                            <div class="input-group">
                                <input type="text" id="nombredueño" name="nombredueño" class="form-control {{ $errors->has('nombredueño') ? ' is-invalid' : '' }}" value="{{old('nombredueño')?old('nombredueño'):$vehiculo->nombredueño}}"  required maxlength="180">
                           
                                @if ($errors->has('nombredueño'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombredueño') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <label class="required">Marca</label>
                            <select id="marca" name="marca" class="select2_form form-control {{ $errors->has('marca') ? ' is-invalid' : '' }}">
                                <option></option>
                                @foreach(marcas() as $marca)
                                    <option value="{{ $marca->simbolo }}" {{ old('marca') ? (old('marca') == $marca->simbolo ? "selected" : "") : ($vehiculo->marca == $marca->simbolo ? "selected" : "") }} >{{ $marca->simbolo }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('marca'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('marca') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3 col-xs-12">
                            <label class="">Estado del Dni</label>
                            <input type="text" id="activodni" name="activodni" class="form-control text-center {{ $errors->has('activodni') ? ' is-invalid' : '' }}" value="{{old('activodni')?old('activodni'):$vehiculo->activodni}}" readonly>
                            @if ($errors->has('activodni'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('activodni') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <label class="">Placa</label>
                            <input type="text" id="placa" name="placa" class="form-control {{ $errors->has('placa') ? ' is-invalid' : '' }}" value="{{old('placa') ? old('placa') : $vehiculo->placa}}" maxlength="191" onkeyup="return mayus(this)">
                                @if ($errors->has('placa'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('placa') }}</strong>
                                    </span>
                                @endif
                          </div>
                          <div class="col-lg-3 col-xs-12">
                            <label class="required">Color</label>
                            <div class="input-group">
                                <input type="text" id="color" name="color" class="form-control {{ $errors->has('color') ? ' is-invalid' : '' }}" value="{{old('color')?old('color'):$vehiculo->color}}"  required>
                                @if ($errors->has('color'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('color') }}</strong>
                                    </span>
                                @endif
                                <!-- <div class="invalid-feedback"><b><span id="error-ruc"></span></b></div> -->
                            </div>
                        </div>
                        
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
            
        </fieldset>
       
        @if (!empty($put))
            <input type="hidden" name="_method" value="PUT">
        @endif
    </form>
</div>

@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <style>
        .logo {
            width: 190px;
            height: 190px;
            border-radius: 10%;
            position: absolute;
        }
    </style>
@endpush
@push('scripts')
    <!-- iCheck -->
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
    
    <script>
      
        $(document).ready(function()
        {
         
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            }); 
            if ($("#activo").val() == ''){ 
                $("#activo").val("SIN VERIFICAR");
            }
            $('.formulario').on('submit',function()
            {
                var x = document.getElementById("contenedor");
           
                 x.style.display = "none";
                 $('.loader-spinner').show();
            });
        });

        function consultarDocumento() {
          
          var dnidueño = $('#dnidueño').val();
          $.ajax({
              dataType : 'json',
              type : 'POST',
              url : '{{ route('vehiculo.getDocumento') }}',
              data : {
                  '_token' : $('input[name=_token]').val(),
                  'documento' : dnidueño,
                  'id': null
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
      function consultarAPI( documento) {
 
            var url = '{{ route("getApidni", ":documento")}}';
            url = url.replace(':documento',documento);
            var textAlert =  "¿Desea consultar DNI a RENIEC?";
            Swal.fire({
                title: 'Consultar', 
                text: textAlert,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: 'Si, Confirmar',
                cancelButtonText: "No, Cancelar",
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                    return fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            else
                            { 
                              return response.json()  
                            }
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                'ocurrio un problema'
                            );
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                console.log(result);
                if (result.value !== undefined && result.isConfirmed) {
                    $('#dnidueño').removeClass('is-invalid')
                        camposDNI(result);
                 
                }
            });
        
    }
    function camposDNI(objeto) {
            if (objeto.value === undefined)
                return;
            var nombres = objeto.value.nombres;
            var apellido_paterno = objeto.value.apellidoPaterno;
            var apellido_materno = objeto.value.apellidoMaterno;
            var nombre = "";
            if (nombres !== '-' && nombres !== null ) {
                nombre += nombres;
            }
            if (apellido_paterno !== '-' && apellido_paterno !== null ) {
                nombre += (nombre.length === 0) ? apellido_paterno : ' ' + apellido_paterno
            }
            if (apellido_materno !== '-' && apellido_materno !== null) {
                nombre += (nombre.length === 0) ? apellido_materno : ' ' + apellido_materno
            }
            $("#nombredueño").val(nombre);
            $("#activodni").val("ACTIVO");
        }
    function clearDatosPersona(limpiarDocumento) {
            if (limpiarDocumento)
                $('#documento').val("");
            $('#nombre').val("");
            $('#direccion_fiscal').val("");
            $('#direccion').val("");
            $('#nombre_comercial')
            $('#correo_electronico').val("");
            $('#telefono_movil').val("");
        }
         $("#form_registrar_vehiculo").steps({
            bodyTag: "fieldset",
            transitionEffect: "fade",
            labels: {
                current: "actual paso:",
                pagination: "Paginación",
                finish: "Finalizar",
                next: "Siguiente",
                previous: "Anterior",
                loading: "Cargando ..."
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
               if (currentIndex > newIndex)
                {
                    return true;
                }
                var form = $(this);
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }
                return validarDatos(currentIndex + 1);
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);
                // Start validation; Prevent form submission if false
                return true;
            },
            onFinished: function (event, currentIndex)
            {
              if(!validarDatos(1))
                {
                   toastr.error('Complete la información de los campos obligatorios (*)','Error');  
                }
                else
                {
                 var form = $(this);

                // Submit form input
                 form.submit();

                    /*    form.addEventListener('loadstart', function(e) {
                        console.log('Image load started');
                        });

                        form.addEventListener('loadend', function(e) {
                        console.log('Image load finished');
                        });*/
              }
            }
        });
        function validarDatos(paso) {
            //console.log("paso: " + paso);
            switch (paso) {
                case 1:
                    return validarDatosPersonales();
                    //return validarDatosContacto();
                default:
                    return false;
            }
        }
        function validarDatosPersonales()
        {
            var dnidueño = $("#dnidueño").val();
            var nombredueño=$("#nombredueño").val();
            var placa=$("#placa").val();
            var marca=$("#marca").val();
            var color = $("#color").val();
            if (
            dnidueño.length === 0
             || nombredueño.length === 0 
             || placa.length === 0 
             || marca.length === 0 
             || color.length === 0 ) {
                return false;
            }
     
                    if (dnidueño.length !== 8) {
                        toastr.error('El Dni debe de contar con 8 dígitos','Error');
                        return false;
                    }
                    
            return true;
        }
    </script>
@endpush