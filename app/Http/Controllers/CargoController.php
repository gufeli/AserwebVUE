<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = Cargo::all();

        return $cargos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // request()->validate([
        //     'name' => 'required',
        // ]);

        //  Cargo::create($request->all());

        //  return redirect()->route('cargos.index')
        //                 ->with('success','Post add successfully.');
        $cargo = new Cargo();
        $cargo->nombre = $request->nombre;
        $cargo->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $cargo = Cargo::find($id);
        // return view('cargos.show', ['cargo' => $cargo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $cargo = Cargo::find($id);

        // return view('cargos.edit', ['cargo' => $cargo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {  
        //  $this->validate($request, [
        //     'name' => 'required',
        // ]);

        // Cargo::find($id)->update($request->all());
        // return redirect()->route('cargos.index')
        //                 ->with('success','Cargo updated successfully');
        $cargo = Cargo::findOrFail($request->id);
        $cargo->nombre = $request->nombre;
        $cargo->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Cargo::destroy($id);
        // return redirect()->route('cargos.index')
        //                 ->with('success', 'Cargo deleted successfully.');
    }
}