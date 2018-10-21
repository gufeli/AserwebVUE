<?php

namespace App\Http\Controllers;

use App\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        $empleados = Empleado::paginate(5);

        return view('empleados.index', ['empleados' => $empleados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'id' => 'required',
            'name' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'correoelectornico' => 'required',
            'tipoid' => 'required',
            'fechanacimiento' => 'required',
            'salario' => 'required',
            'id_cargo' => 'required',

        ]);

         Empleado::create($request->all());

         return redirect()->route('empleados.index')
                        ->with('success','Post add successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        $empleado = Empleado::find($id);
        return view('empleados.show', ['empleado' => $empleado]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $empleado = Empleado::find($id);

        return view('empleados.edit', ['empleado' => $empleado]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'correoelectornico' => 'required',
            'tipoid' => 'required',
            'fechanacimiento' => 'required',
            'salario' => 'required',
            'id_cargo' => 'required',
        ]);

        Empleado::find($id)->update($request->all());
        return redirect()->route('empleados.index')
                        ->with('success','Empleado updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        Empleado::destroy($id);
        return redirect()->route('empleados.index')
                        ->with('success', 'Empleado deleted successfully.');
    }
}