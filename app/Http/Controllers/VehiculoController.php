<?php

namespace App\Http\Controllers;

use App\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return PHP_VERSION_ID; 
        return view('vehiculos.index');
    }
    public function  getTable()
    {
        $resultado=DB::table('vehiculos')->where('estado','ACTIVO')->get();
        return DataTables::of($resultado)->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $vehiculo= new Vehiculo();
        $action = route('vehiculo.store');
        return view('vehiculos.create')->with(compact('vehiculo','action'));
    }
    public function getDocumento(Request $request)
    {
        $data = $request->all();
        $existe = false;
        $igualPersona = false;
        if (!is_null($data['documento'])) {
            if (!is_null($data['id'])) {
                $vehiculo= Vehiculo::findOrFail($data['id']);
                if ( $vehiculo->dnidueño == $data['documento']) {
                    $igualPersona = true;
                } else {
                    $vehiculo= Vehiculo::where([
                        ['dnidueño', $data['documento']],
                        ['estado', 'ACTIVO']
                    ])->first();
                }
            } else {
                $vehiculo = Vehiculo::where([
                    ['dnidueño', $data['documento']],
                    ['estado', 'ACTIVO']
                ])->first();
            }

            if (!is_null($vehiculo)) {
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
            'dnidueño' => ['required','numeric', Rule::unique('vehiculos','dnidueño')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'nombredueño' => 'required',
            'activodni' => 'required',
            'placa' => 'required',
            'marca' => 'required',
            'color' => 'required',
            
        ];
        $message = [
            'dnidueño.required' => 'El campo Nro. Documento es obligatorio',
            'dnidueño.unique' => 'El campo Nro. Documento debe ser único',
            'dnidueño.numeric' => 'El campo Nro. Documento debe ser numérico',
            'nombredueño.required' => 'El propietario es obligatorio',
            'activodni.required' => 'El campo Estado es obligatorio',
            'placa.required' => 'La placa es obligatorio',
            'marca.required'=>'El campo marca es obligatorio',
            'color.required'=>'El campo color es obligatorio',
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $vehiculo = new Vehiculo();
        $vehiculo->nombredueño = $request->nombredueño;
        $vehiculo->dnidueño = $request->dnidueño;
        $vehiculo->marca = $request->marca;
        $vehiculo->activodni = $request->activodni;
        $vehiculo->placa = $request->placa;
        $vehiculo->color = $request->color;
        $vehiculo->save();


        return redirect()->route('vehiculo.index')->with('guardar', 'success');
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
        $vehiculo = Vehiculo::findOrFail($id);
        
        $put = True;
        $action = route('vehiculo.update', $id);

        return view('vehiculos.edit', [
            'vehiculo' => $vehiculo,
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
            'dnidueño' => ['required','numeric', Rule::unique('vehiculos','dnidueño')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })->ignore($id)],
            'nombredueño' => 'required',
            'activodni' => 'required',
            'placa' => 'required',
            'marca' => 'required',
            'color' => 'required',
            
        ];
        $message = [
            'dnidueño.required' => 'El campo Nro. Documento es obligatorio',
            'dnidueño.unique' => 'El campo Nro. Documento debe ser único',
            'dnidueño.numeric' => 'El campo Nro. Documento debe ser numérico',
            'nombredueño.required' => 'El propietario es obligatorio',
            'activodni.required' => 'El campo Estado es obligatorio',
            'placa.required' => 'La placa es obligatorio',
            'marca.required'=>'El campo marca es obligatorio',
            'color.required'=>'El campo color es obligatorio',
        ];

        Validator::make($data, $rules, $message)->validate();
       
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->nombredueño = $request->nombredueño;
        $vehiculo->dnidueño = $request->dnidueño;
        $vehiculo->marca = $request->marca;
        $vehiculo->activodni = $request->activodni;
        $vehiculo->placa = $request->placa;
        $vehiculo->color = $request->color;
        $vehiculo->save();


        return redirect()->route('vehiculo.index')->with('guardar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehiculo=Vehiculo::findOrFail($id);
        $vehiculo->estado = 'ANULADO';
        $vehiculo->update();

        //Registro de actividad
       

        return redirect()->route('vehiculo.index')->with('eliminar', 'success');
    }
}
