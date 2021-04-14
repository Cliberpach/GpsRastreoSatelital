<?php

namespace App\Http\Controllers;

use App\Clienteapp;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios.index');
    }
    public function getTable()
    {
        return datatables()->query(
            DB::table('users')
            ->join('role_user','role_user.user_id','=','users.id')
            ->join('roles','roles.id','=','role_user.role_id')
            ->select('users.*','roles.name as rol')
            ->where('users.estado','ACTIVO')
            ->orderBy('users.id', 'desc'))->toJson();
    }
    public function cambiarrol(Request $request)
    {
        $user_id=$request->user_id;
        $rol_id=$request->rol_id;
        $id_rol=DB::table('role_user')->where('user_id',$user_id)->first();
        $rol=RoleUser::findOrFail($id_rol->id);
        $rol->role_id=$rol_id;
        $rol->update();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function inicio(Request $request)
    {
        
        return $request;
    }
    public function register()
    {
        return view('register.index');
    }
    public function registerclienteapp(Request $request)
    {
        registro_app($request);
        return redirect()->route('login')->with('guardar', 'success');
    }
    public function registerapp(Request $request)
    {
       if(DB::table('users')->where('email',$request->email)->count()==0)
       {
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
        return "Registro con Exito";
       }
       else
       {
           return json_encode(array("Mensaje"=>"Este email ya esta registrado"));
       }
       
      
    }
}
