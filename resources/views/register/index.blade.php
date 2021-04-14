@extends('layouts.app')
@section('content')
<div class="loader-spinner">
    <div class="centrado" id="onload">
        <div class="loadingio-spinner-blocks-zcepr5tohl">
            <div class="ldio-6fqlsp2qlpd">
                <div style='left:38px;top:38px;animation-delay:0s'></div>
                <div style='left:80px;top:38px;animation-delay:0.125s'></div>
                <div style='left:122px;top:38px;animation-delay:0.25s'></div>
                <div style='left:38px;top:80px;animation-delay:0.875s'></div>
                <div style='left:122px;top:80px;animation-delay:0.375s'></div>
                <div style='left:38px;top:122px;animation-delay:0.75s'></div>
                <div style='left:80px;top:122px;animation-delay:0.625s'></div>
                <div style='left:122px;top:122px;animation-delay:0.5s'></div>
            </div>
        </div>
    </div>
</div>
<div id="content-system" style="display:none;">
    <div class="container-fluid">
        <div class="row" style="height:100vh;">
            @if(verificarempresaloginlarge())
            <div class="col-lg-6 col-md-6 d-none d-md-block" style="height:100vh;background: url('{{Storage::url(empresacolor()->ruta_logo_large)}}');
            background-size: cover;"></div>
            @else

            <div class="col-lg-6 col-md-6 d-none d-md-block" style="height:100vh;background: url('/img/banner_ecovalle.jpeg');
            background-size: cover;">
            </div>
            @endif
            <div class="col-lg-6 col-md-6 form-container" >
                <div class="login">
                    <div class="text-center">
                        @if(verificarempresaloginicon())
                        <img src="{{Storage::url(empresacolor()->ruta_logo_icon)}}" width="150" class="img-responsive m-b">
                        @else
                          <img src="{{asset('img/e.png')}}" width="150" class="img-responsive m-b">
                        @endif
                      
                    </div>

                 
                    <div class="card" style="width: 400px;margin:0px 0px 0px 22%;padding:10px 10px 10px 10px;">
                        <h3>SISTEMA DE GPS TRACKER</h3>
    
                        <p>
                            Ingresas tus datos para registrarse
                        </p>
                    <form  role="form" method="POST" action="{{ route('registrar.clienteapp') }}" id="frm_clienteapp">
                        @csrf

                        <div class="form-group" style="padding:0px;">
                            <input id="nombre" type="nombre"  class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required  autofocus placeholder="Nombre y apellidos"  >
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   
                            <div class="form-group" style="padding:0px;">
                            <input id="email" type="email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo Electrónico"  >
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>

                            <div class="form-group" style="padding:0px;">
                            <input id="password" type="password"  class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>

                            <div class="form-group" style="padding:0px;">
                            <input id="confirmpassword" type="password"   class="form-control @error('confirmpassword') is-invalid @enderror" name="confirmpassword" autocomplete="current-password" required  placeholder="Confirmar Contraseña">
                            @error('confirmpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                           
                            <div class="form-group" style="padding:0px;">
                            <input id="telefono" type="telefono"   class="form-control @error('telefono') is-invalid @enderror" name="telefono" required  placeholder="Telefono" maxlength="9">
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                       
                            <button type="button" class="btn btn-primary  m-b btn-margin-sesion"  onclick="registrar()">Registrarse</button>
                            <br>
                    
                        <a href="{{ route('login') }}" style="font-size:17px;"><small>Iniciar Sesión</small></a>
                        <br>
                    </form>
                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
     function registrar()
     {
         var enviar=0;

        if($("#password").val().length>=8 && $("#confirmpassword").val().length>=8)
        {
            if($("#password").val()==$("#confirmpassword").val())
         {
            if($("#password").val()=="" || $("#confirmpassword").val()=="")
            {
                toastr.error('Campo en blanco','Error');
            }
            else
            {
                enviar=1;

            }
            
         }
         else{
            toastr.error('Las contraseñas no coinciden','Error');
        
         }
         if(enviar!=0)
         {
           document.getElementById("frm_clienteapp").submit();  
         }
        }
        else{
            toastr.error('Contraseñas cortas','Error');
            
        }
         
         
     }

</script>
@endsection
