<?php

namespace App\Http\Controllers;

use App\Carrera;
use App\User;
use App\Carrerapuntuacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     return view('carreras.index');
    }
    public function getTable()
    {
        $data=DB::table('carrera as c')
        ->join('clienteapp as cl','cl.user_id','=','c.user_id')
        ->join('conductores as co','co.id','=','c.conductor_id')
        ->select('co.nombre as conductor','cl.nombre as cliente','c.*')
        ->where('c.estado','ACTIVO')->get();
        return DataTables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('carreras.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carrera= new Carrera();
        $carrera->hora=$request->hora;
        $carrera->referencia=$request->referencia;
        $carrera->direccionInicial=$request->direccionInicial;
        $carrera->direccionFinal=$request->direccionFinal;
        $carrera->importe=$request->importe;
        $carrera->conductor_id=$request->conductor_id;
        $carrera->user_id=$request->cliente_id;
        $carrera->latinicial=$request->latinicial;
        $carrera->latfinal=$request->latfinal;
        $carrera->lnginicial=$request->lnginicial;
        $carrera->lngfinal=$request->lngfinal;
        $carrera->save();
        $resultado=array("Respuesta"=>"Exito ");
        return json_encode($resultado);
       
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carrera=Carrera::findOrFail($id);
        return view('carreras.edit', [
            'carrera' => $carrera
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }
    public function actualizar(Request $request)
    {
        $carrera= Carrera::findOrFail($request->id);
        $carrera->hora=$request->hora;
        $carrera->direccionInicial=$request->direccionInicial;
        $carrera->referencia=$request->referencia;
        $carrera->direccionFinal=$request->direccionFinal;
        $carrera->importe=$request->importe;
        $carrera->conductor_id=$request->conductor_id;
        $carrera->user_id=$request->cliente_id;
        $carrera->latinicial=$request->latinicial;
        $carrera->latfinal=$request->latfinal;
        $carrera->lnginicial=$request->lnginicial;
        $carrera->lngfinal=$request->lngfinal;
        $carrera->save();
        $resultado=array("Respuesta"=>"Exito ");
        return json_encode($resultado);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->estado = 'ANULADO';
        $carrera->update();

        //Registro de actividad
       

        return redirect()->route('carrera.index')->with('eliminar', 'success');
    }
    public function consulta()
    {
        return view('carreras.consulta.index');
    }
    public function puntuacion(Request $request)
    {
        $user=User::findOrFail($request->user_id);
      //aplicativo // $user= $request->user();
        if(DB::table('carrera')->where('id',$request->carrera)->count()!=0)
        {
            if(DB::table('carrerapuntuacion')->where('user_id',$user->id)->where('carrera_id',$request->carrera)->count()==0)
            {
                $carrerapuntuacion=new Carrerapuntuacion();
                $carrerapuntuacion->carrera_id=$request->carrera;
                $carrerapuntuacion->user_id=$user->id;
                $carrerapuntuacion->puntuacion=$request->puntuacion;
                $carrerapuntuacion->save();
                return json_encode(array("Mensaje"=>"Puntuacion registrada"));
            }
            else{
                $cp=DB::table('carrerapuntuacion')->where('user_id',$user->id)->where('carrera_id',$request->carrera)->first();
                $carrerapuntuacion=Carrerapuntuacion::findOrFail($cp->id);
                $carrerapuntuacion->puntuacion=$request->puntuacion;
                $carrerapuntuacion->save();
                return json_encode(array("Mensaje"=>"Puntuacion Actualizada"));

            } 
        }
        else
        {
            return  json_encode(array("Mensaje"=>"Esa Carrera ya Existe"));
        }
        
    }
    public function consultarcarreras(Request $request)
    {
               
        $conductor=$request->conductor;
        $cliente=$request->cliente;
        $fecha_inicio=$request->fechainicio;
        $fecha_final=$request->fechafinal;
        $resultado=array();
        if($request->cliente!="")
        {
            $data=DB::table('carrera as c')
                    ->join('clienteapp as cl','cl.user_id','=','c.user_id')
                    ->join('conductores as co','co.id','=','c.conductor_id')
                    ->join('vehiculos as v','v.id','=','co.vehiculo_id')
        
                    ->select('c.*','v.placa')
                    ->where('c.estado','ACTIVO')
                    ->where('cl.id',$cliente)
                    ->get();
                    foreach($data as $dato)
                    {
                        $puntuacion="Sin puntuacion";
                        if(DB::table('carrerapuntuacion')->where('carrera_id',$dato->id)->count()!=0)
                        {
                            $valor=DB::table('carrerapuntuacion')->where('carrera_id',$dato->id)->first();
                            $puntuacion=$valor->puntuacion;
                        }
                        array_push($resultado,array("latinicial"=>$dato->latinicial,
                                                    "lnginicial"=>$dato->lnginicial,
                                                    "latfinal"=>$dato->latfinal,
                                                    "lngfinal"=>$dato->lngfinal,
                                                    "placa"=>$dato->placa,
                                                    "direccionInicial"=>$dato->direccionInicial,
                                                    "direccionFinal"=>$dato->direccionFinal,
                                                    "puntuacion"=>$puntuacion,
                                                    "estadocarrera"=>$dato->estadocarrera
                    ));
                    }
        }
        else if($request->conductor!="")
        {
            $data=DB::table('carrera as c')
            ->join('conductores as co','co.id','=','c.conductor_id')
            ->join('vehiculos as v','v.id','=','co.vehiculo_id')

            ->select('c.*','v.placa')
            ->where('c.estado','ACTIVO')
            ->where('co.id',$conductor)
            ->get();
            foreach($data as $dato)
            {
                $puntuacion="Sin puntuacion";
                if(DB::table('carrerapuntuacion')->where('carrera_id',$dato->id)->count()!=0)
                {
                    $valor=DB::table('carrerapuntuacion')->where('carrera_id',$dato->id)->first();
                    $puntuacion=$valor->puntuacion;
                }
                array_push($resultado,array("latinicial"=>$dato->latinicial,
                                            "lnginicial"=>$dato->lnginicial,
                                            "latfinal"=>$dato->latfinal,
                                            "lngfinal"=>$dato->lngfinal,
                                            "placa"=>$dato->placa,
                                            "direccionInicial"=>$dato->direccionInicial,
                                            "direccionFinal"=>$dato->direccionFinal,
                                            "puntuacion"=>$puntuacion,
                                            "estadocarrera"=>$dato->estadocarrera
            ));
            }
        }
        else{
            $data=DB::table('carrera as c')
            ->join('clienteapp as cl','cl.user_id','=','c.user_id')
            ->join('conductores as co','co.id','=','c.conductor_id')
            ->join('vehiculos as v','v.id','=','co.vehiculo_id')

            ->select('c.*','v.placa')
            ->where('c.estado','ACTIVO')
            ->where('cl.id',$cliente)
            ->where('co.id',$conductor)
            ->get();
            foreach($data as $dato)
            {
                $puntuacion="Sin puntuacion";
                if(DB::table('carrerapuntuacion')->where('carrera_id',$dato->id)->count()!=0)
                {
                    $valor=DB::table('carrerapuntuacion')->where('carrera_id',$dato->id)->first();
                    $puntuacion=$valor->puntuacion;
                }
                array_push($resultado,array("latinicial"=>$dato->latinicial,
                                            "lnginicial"=>$dato->lnginicial,
                                            "latfinal"=>$dato->latfinal,
                                            "lngfinal"=>$dato->lngfinal,
                                            "placa"=>$dato->placa,
                                            "direccionInicial"=>$dato->direccionInicial,
                                            "direccionFinal"=>$dato->direccionFinal,
                                            "puntuacion"=>$puntuacion,
                                            "estadocarrera"=>$dato->estadocarrera
            ));
            }
        }
        return $resultado;

    }
    public function consultarcarreraspdf(Request $request)
    {

    }
}
