<?php
use App\Mantenimiento\Tabla\General;
use App\Mantenimiento\Tabla\Detalle;
use App\Mantenimiento\Ubigeo\Departamento;
use App\Mantenimiento\Ubigeo\Distrito;
use App\Mantenimiento\Ubigeo\Provincia;
use App\Clienteapp;
use Illuminate\Support\Facades\Log;
use App\Parametro;
use Illuminate\Http\Request;
use App\TipoDispositivo;
use App\Dispositivo;
use App\Permission\Models\Permission;
use App\Cliente;
use App\Empresa;
use App\User;
// use App\Parametro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
//Aplicativo
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


//Bitacora de actividades
use Spatie\Activitylog\Contracts\Activity;
use Illuminate\Support\Facades\Auth;

//Facturacion Electronica
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

// TABLAS-DETALLES


// UBIGEO

if (!function_exists('getFechaFormato')) {
    function getFechaFormato($fecha, $formato)
    {
        if (is_null($fecha) || empty($fecha))
            return "-";

        $fecha_formato = Carbon::parse($fecha)->format($formato);
        return ($fecha_formato) ? $fecha_formato : $fecha;
    }
}
if (!function_exists('tipos_documento')) {
    function tipos_documento()
    {
        return General::find(3)->detalles;
    }
}
if (!function_exists('tipos_sexo')) {
    function tipos_sexo()
    {
        return General::find(4)->detalles;
    }
}

//Consultas a la Api
if (!function_exists('consultaRuc')) {
    function consultaRuc()
    {
        return Parametro::findOrFail(1);
    }
}
if (!function_exists('consultaDni')) {
    function consultaDni()
    {
        return Parametro::findOrFail(2);
    }
}
if (!function_exists('tiposdispositivos')) {
    function tiposdispositivos()
    {
        return TipoDispositivo::where('estado','ACTIVO')->where('activo','VIGENTE')->get();
    }
}
if (!function_exists('dispositivos')) {
    function dispositivos()
    {
        return DB::table('dispositivo')
        ->join('tipodispositivo','tipodispositivo.id','=','dispositivo.tipodispositivo_id')
        ->select('dispositivo.*','tipodispositivo.precio')
        ->where('tipodispositivo.activo','VIGENTE')
        ->where('tipodispositivo.estado','ACTIVO')
        ->where('dispositivo.estado','ACTIVO')->get();
    }
}
if (!function_exists('operadores')) {
    function operadores()
    {
        return General::find(6)->detalles;
    }
}
if (!function_exists('clientes')) {
    function clientes()
    {
        return Cliente::where('estado','ACTIVO')->get();
    }
}
if (!function_exists('empresas')) {
    function empresas()
    {
        return Empresa::where('estado','ACTIVO')->get();
    }
}
if (!function_exists('bancos')) {
    function bancos()
    {
        return General::find(2)->detalles;
    }
}
if (!function_exists('areas')) {
    function areas()
    {
        return General::find(7)->detalles;
    }
}
if (!function_exists('cargos')) {
    function cargos()
    {
        return General::find(8)->detalles;
    }
}
if (!function_exists('estados_civiles')) {
    function estados_civiles()
    {
        return General::find(5)->detalles;
    }
}
if (!function_exists('modelos')) {
    function modelos()
    {
        return General::find(12)->detalles;
    }
}

if (!function_exists('marcas')) {
    function marcas()
    {
        return General::find(13)->detalles;
    }
}

// UBIGEO
if (!function_exists('departamentos')) {
    function departamentos($id = null)
    {
        if (is_null($id)) {
            return Departamento::all();
        } else {
            $departamento_id = str_pad($id, 2, "0", STR_PAD_LEFT);
            return Departamento::where('id', $id)->get();
        }
    }
}

if (!function_exists('provincias')) {
    function provincias($id = null)
    {
        if (is_null($id)) {
            return Provincia::all();
        } else {
            $provincia_id = str_pad($id, 4, "0", STR_PAD_LEFT);
            return Provincia::where('id', $provincia_id)->get();
        }
    }
}

if (!function_exists('getProvinciasByDepartamento')) {
    function getProvinciasByDepartamento($departamento_id)
    {
        if (is_null($departamento_id)) {
            return collect([]);
        } else {
            $departamento_id = str_pad($departamento_id, 2, "0", STR_PAD_LEFT);
            return Provincia::where('departamento_id', $departamento_id)->get();
        }
    }
}

if (!function_exists('distritos')) {
    function distritos($id = null)
    {
        if (is_null($id)) {
            return Distrito::all();
        } else {
            $distrito_id = str_pad($id, 6, "0", STR_PAD_LEFT);
            return Distrito::where('id', $distrito_id)->get();
        }
    }
}

if (!function_exists('getDistritosByProvincia')) {
    function getDistritosByProvincia($provincia_id)
    {
        if (is_null($provincia_id)) {
            return collect([]);
        } else {
            $provincia_id = str_pad($provincia_id, 4, "0", STR_PAD_LEFT);
            return Distrito::where('provincia_id', $provincia_id)->get();
        }
    }
}
if (!function_exists('profesiones')) {
    function profesiones()
    {
        return General::find(9)->detalles;
    }
}
if (!function_exists('tipos_moneda')) {
    function tipos_moneda()
    {
        return General::find(1)->detalles;
    }
}
if (!function_exists('bancos')) {
    function bancos()
    {
        return General::find(2)->detalles;
    }
}
if (!function_exists('grupos_sanguineos')) {
    function grupos_sanguineos()
    {
        return General::find(10)->detalles;
    }
}

if (!function_exists('tipos_venta')) {
    function tipos_venta()
    {
        return General::find(11)->detalles;
    }
}
if (!function_exists('generarcontrase??acliente')) {
    function generarcontrase??acliente($usuario)
    {
        return substr($usuario->nombre,0,4).rand(0,20);
    }
}
if (!function_exists('generarcontrase??aempresa')) {
    function generarcontrase??aempresa($usuario)
    {
        return substr($usuario->nombre_comercial,0,4).rand(0,20);
    }
}
if (!function_exists('empresacolor')) {
    function empresacolor()
    {
        return DB::table('empresa')->where('estado','ACTIVO')->first();
    }
}
if (!function_exists('verificarempresa')) {
    function verificarempresa()
    {
        $valor=true;
        if(DB::table('empresa')->where('estado','ACTIVO')->count()==0)
        {
            $valor=false;
        }

        return $valor;
    }
}
if (!function_exists('verificarempresaloginlarge')) {
    function verificarempresaloginlarge()
    {
        $valor=true;
        if(DB::table('empresa')->where('estado','ACTIVO')->whereNotNull('ruta_logo_large')->count()==0)
        {
            $valor=false;
        }

        return $valor;
    }
}
if (!function_exists('verificarempresaloginicon')) {
    function verificarempresaloginicon()
    {
        $valor=true;
        if(DB::table('empresa')->where('estado','ACTIVO')->whereNotNull('ruta_logo_icon')->count()==0)
        {
            $valor=false;
        }

        return $valor;
    }
}
if (!function_exists('dispositivoscontrato')) {
    function dispositivoscontrato()
    {
        return DB::table('detallecontrato as dc')
                    ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
                    ->join('contrato as c','c.id','=','dc.contrato_id')
                    ->select('d.*')
                    ->where('c.estado','ACTIVO')
                    ->get();
    }
}

if (!function_exists('dispositivo_user')) {
    function dispositivo_user(User $user)
    {

        if($user->tipo=='ADMIN')
        {
           return DB::table('detallecontrato as dc')
                    ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
                    ->join('contrato as c','c.id','=','dc.contrato_id')
                    ->select('d.*')
                    ->where('d.estado','ACTIVO')
                    ->where('c.estado','ACTIVO')
                    ->get();

        }
        else if($user->tipo=='CLIENTE')
        {
            $cliente=DB::table('clientes')->where('user_id',$user->id)->first();
            return DB::table('detallecontrato as dc')
            ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
            ->join('contrato as c','c.id','=','dc.contrato_id')
            ->select('d.*')
            ->where('d.estado','ACTIVO')
            ->where('c.estado','ACTIVO')
            ->where('c.cliente_id',$cliente->id)
            ->get();
        }
        else if($user->tipo=='EMPRESA')
        {
            $empresa=DB::table('empresas')->where('user_id',$user->id)->first();
            return DB::table('detallecontrato as dc')
            ->join('dispositivo as d','d.id','=','dc.dispositivo_id')
            ->join('contrato as c','c.id','=','dc.contrato_id')
            ->select('d.*')
            ->where('d.estado','ACTIVO')
            ->where('c.estado','ACTIVO')
            ->where('c.empresa_id',$empresa->id)
            ->get();
        }
       /* return DB::table('dispositivo as d')
                    ->join('ubicacion as u','u.dispositivo_id','=','d.id')
                    ->select('d.*','u.lat','u.lng')
                    ->where('d.estado','ACTIVO')
                    ->get();*/
    }
}

if (!function_exists('roles')) {
    function roles()
    {
       
        return  json_encode(DB::table('roles')
        ->get());
    }
}
if (!function_exists('find_dispositivo')) {
    function find_dispositivo($imei)
    {
       $existe=true; 
      // Log::info($imei);
        
       $valor=DB::table('estadodispositivo')->where('cadena','like','%'.$imei.'%')->orderByDesc('fecha')->first();
        if($valor=="")
        {
            $valor=DB::table('estadodispositivo')->where('imei','like','%'.$imei.'%')->orderByDesc('fecha')->first();
        }
        if($valor->estado=="Desconectado")
        {
            $existe=false;
        }	
            return $existe;
        }
}
if (!function_exists('find_dispositivo_movimiento')) {
    function find_dispositivo_movimiento($imei)
    {
       $existe=true;
       $valor=DB::table('estadodispositivo')->where('cadena','like','%'.$imei.'%')->orderByDesc('fecha')->first();
       if($valor=="")
               {
                   $valor=DB::table('estadodispositivo')->where('imei','like','%'.$imei.'%')->orderByDesc('fecha')->first();
               }
	if($valor->movimiento=="Sin Movimiento")
	{
         $existe=false;
	}	
        return $existe;
    }
}

if (!function_exists('dispositivogps_user')) {
    function dispositivogps_user(User $user)
    {

        if($user->tipo=='ADMIN')
        {
           return DB::select("SELECT t1.* FROM (select d.color,u.id,u.imei,u.cadena,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
        }
        else if($user->tipo=='CLIENTE')
        {
           
            $cliente=DB::table('clientes')->where('user_id',$user->id)->first();
           return DB::select("SELECT t1.* FROM (select d.color,u.id,u.imei,u.cadena,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and c.cliente_id='".$cliente->id."') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 and c.cliente_id='".$cliente->id."' ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
        }
        else if($user->tipo=='EMPRESA')
        {
            $empresa=DB::table('empresas')->where('user_id',$user->id)->first();
            return DB::select("SELECT t1.* FROM (select d.color,u.id,u.imei,u.cadena,u.lat,u.lng,u.fecha,d.placa,d.marca,d.modelo,d.nombre from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and c.empresa_id='".$empresa->id."') t1 INNER JOIN (SELECT tabla.imei, MAX(tabla.fecha) as fecha FROM (select u.imei,u.lat,u.lng,u.fecha from detallecontrato as dc inner join dispositivo as d on d.id=dc.dispositivo_id inner join contrato as c on c.id=dc.contrato_id inner join ubicacion as u on u.imei=d.imei where d.estado='ACTIVO' and c.estado='ACTIVO' and u.lat!=0 and u.lng!=0 and c.empresa_id='".$empresa->id."' ) as tabla GROUP BY  tabla.imei ) t2 ON t1.imei = t2.imei AND t1.fecha = t2.fecha;");
        }
       /* return DB::table('dispositivo as d')
                    ->join('ubicacion as u','u.dispositivo_id','=','d.id')
                    ->select('d.*','u.lat','u.lng')
                    ->where('d.estado','ACTIVO')
                    ->get();*/
    }
}
if(!function_exists('rangos'))
{
    function rangos()
    {
        return DB::table('rango')->get();
    }

}
if (!function_exists('dispositivo_activos')) {
    function dispositivo_activos(User $user)
{
    $dispositivos=dispositivo_user($user);
    $activos=0;
    foreach($dispositivos as $dispositivo)
    {
        if(find_dispositivo_movimiento($dispositivo->imei))
        {
            $activos=$activos+1;
        }
       
    }
    return $activos;
    }
}
if (!function_exists('dispositivo_inactivos')) {
    function dispositivo_inactivos(User $user)
    {
        $dispositivos=dispositivo_user($user);
        $inactivos=0;
        foreach($dispositivos as $dispositivo)
        {
            if(!find_dispositivo_movimiento($dispositivo->imei))
            {
                $inactivos=$inactivos+1;
            }
        
        }
        return $inactivos;
    }
}
if (!function_exists('alertas'))
{
    function alertas()
    {
      return DB::table('alertas')->get();
    }
}
//aplicativo
if (!function_exists('conductor'))
{
    function conductor()
    {
      return DB::table('conductores')->where('estado','ACTIVO')->get();
    }
}
if (!function_exists('cliente_app'))
{
    function cliente_app()
    {
      return DB::table('clienteapp')->where('estado','ACTIVO')->get();
    }
}
if (!function_exists('vehiculos'))
{
    function vehiculos()
    {
      return DB::table('vehiculos')->where('estado','ACTIVO')->get();
    }
}
if (!function_exists('Conductores'))
{
    function Conductores()
    {
      return DB::table('conductores')->where('estado','ACTIVO')->get();
    }
}
if (!function_exists('registro_app'))
{
    function registro_app(Request $request)
    {
        $data = $request->all();

        $rules = [
            'nombre' => 'required',
            'email' => ['required', Rule::unique('users','email')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'telefono' => 'required|numeric'
            
        ];
        $message = [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio',
            'email.unique'=>"Este email ya se ha registrado",
            'telefono.numeric' => 'El campo telefono debe ser num??rico',
            'telefono.required' => 'El campo telefono es obligatorio',
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $cliente = new Clienteapp();
        $cliente->nombre = $request->nombre;
        $cliente->telefono = $request->telefono;


       

       // config(['mail.username' => 'cs3604302@gmail.com']);
        //config(['mail.password' => 'xxxredtyciquzaja']);
    

        $usuario=User::create([
            'usuario'=> $request->nombre,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'tipo'=>'OTRO'
        ]);
        $cliente->user_id=$usuario->id;

        $cliente->save();
    }
}

