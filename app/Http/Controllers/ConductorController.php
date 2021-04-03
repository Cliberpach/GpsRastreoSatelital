<?php

namespace App\Http\Controllers;

use App\Conductor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConductorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('conductores.index');
    }
    public function getTable()
    {
       
     
        $data= DB::table('conductores')->select('*')->where('conductores.estado','ACTIVO')->orderBy('conductores.id', 'desc')->get();
        return Datatables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = route('conductor.store');
        $conductor = new Conductor();
        return view('conductores.create')->with(compact('action','conductor'));
    }
    public function getDocumento(Request $request)
    {
        $data = $request->all();
        $existe = false;
        $igualPersona = false;
        if (!is_null($data['tipo_documento']) && !is_null($data['documento'])) {
            if (!is_null($data['id'])) {
                $conductor = Conductor::findOrFail($data['id']);
                if ($conductor->tipo_documento == $data['tipo_documento'] && $conductor->documento == $data['documento']) {
                    $igualPersona = true;
                } else {
                    $conductor = Conductor::where([
                        ['tipo_documento', '=', $data['tipo_documento']],
                        ['documento', $data['documento']],
                        ['estado', 'ACTIVO']
                    ])->first();
                }
            } else {
                $conductor = Conductor::where([
                    ['tipo_documento', '=', $data['tipo_documento']],
                    ['documento', $data['documento']],
                    ['estado', 'ACTIVO']
                ])->first();
            }

            if (!is_null($conductor)) {
                $existe = true;
            }
        }

        $result = [
            'existe' => $existe,
            'igual_persona' => $igualPersona
        ];

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $rules = [
            'tipo_documento' => 'required',
            'documento' => ['required','numeric', Rule::unique('conductores','documento')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'activo' => 'required',
            'nombre' => 'required',
            'telefono_movil' => 'required|numeric',
            'direccion' => 'required',
            'correo_electronico' => 'required',
            'imei' => 'required',
            
        ];
        $message = [
            'tipo_documento.required' => 'El campo Tipo de documento es obligatorio.',
            'documento.required' => 'El campo Nro. Documento es obligatorio',
            'documento.unique' => 'El campo Nro. Documento debe ser único',
            'documento.numeric' => 'El campo Nro. Documento debe ser numérico',
            'activo.required' => 'El campo Estado es obligatorio',
            'nombre.required' => 'El Nombre es obligatorio',
            'telefono_movil.required' => 'El campo Teléfono móvil es obligatorio',
            'telefono_movil.numeric' => 'El campo Teléfono móvil debe ser numérico',
            'direccion.required'=>'El campo direccion es obligatorio',
            'correo_electronico.required' => 'El campo Correo es Obligatorio',
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $conductor = new Conductor();
        $conductor->tipo_documento = $request->tipo_documento;
        $conductor->documento = $request->documento;
        $conductor->imei = $request->imei;
        $conductor->nombre = $request->nombre;
        $conductor->activo = $request->activo;
        $conductor->telefono_movil = $request->telefono_movil;
        $conductor->direccion=$request->direccion;
        $conductor->correo_electronico=$request->correo_electronico;
        $conductor->nombre_contacto=$request->nombre_contacto;
        $conductor->tipo_documento_contacto=$request->tipo_documento_contacto;
        $conductor->documento_contacto=$request->documento_contacto;

        $conductor->save();

        return redirect()->route('conductor.index')->with('guardar', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conductor = Conductor::findOrFail($id);
        return view('conductores.show', [
            'conductor' => $conductor
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $conductor = Conductor::findOrFail($id);
        
        $put = True;
        $action = route('conductor.update', $id);

        return view('conductores.edit', [
            'conductor' => $conductor,
            'action' => $action,
            'put' => $put,
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
        $data = $request->all();

        $rules = [
            'tipo_documento' => 'required',
            'documento' => ['required','numeric', Rule::unique('conductores','documento')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })->ignore($id)],
            'activo' => 'required',
            'nombre' => 'required',
            'telefono_movil' => 'required|numeric',
            'direccion' => 'required',
            'correo_electronico' => 'required',
            'imei' => 'required',
            
        ];
        $message = [
            'tipo_documento.required' => 'El campo Tipo de documento es obligatorio.',
            'documento.required' => 'El campo Nro. Documento es obligatorio',
            'documento.unique' => 'El campo Nro. Documento debe ser único',
            'documento.numeric' => 'El campo Nro. Documento debe ser numérico',
            'activo.required' => 'El campo Estado es obligatorio',
            'nombre.required' => 'El Nombre es obligatorio',
            'telefono_movil.required' => 'El campo Teléfono móvil es obligatorio',
            'telefono_movil.numeric' => 'El campo Teléfono móvil debe ser numérico',
            'direccion.required'=>'El campo direccion es obligatorio',
            'correo_electronico.required' => 'El campo Correo es Obligatorio',
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $conductor = Conductor::findOrFail($id);
        $conductor->tipo_documento = $request->tipo_documento;
        $conductor->documento = $request->documento;
        $conductor->imei = $request->imei;
        $conductor->nombre = $request->nombre;
        $conductor->activo = $request->activo;
        $conductor->telefono_movil = $request->telefono_movil;
        $conductor->direccion=$request->direccion;
        $conductor->correo_electronico=$request->correo_electronico;
        $conductor->nombre_contacto=$request->nombre_contacto;
        $conductor->tipo_documento_contacto=$request->tipo_documento_contacto;
        $conductor->documento_contacto=$request->documento_contacto;

        $conductor->save();

        return redirect()->route('conductor.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conductor= Conductor::findOrFail($id);
        $conductor->estado = 'ANULADO';
        $conductor->update();

        //Registro de actividad
       

        return redirect()->route('conductor.index')->with('eliminar', 'success');
    }
}
