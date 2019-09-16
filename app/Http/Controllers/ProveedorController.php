<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use App\Proveedor;

use App\Http\Requests\ProveedorRequest;

use DB;

class ProveedorController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request)
        {
            $query = trim($request->get('searchText'));
            $proveedores = DB::table('proveedor')
            ->where('empresa','LIKE','%'.$query.'%')
            ->orderBy('id','desc')
            ->paginate(7);

            return view('local.proveedor.index',["proveedores"=>$proveedores,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("local.proveedor.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProveedorRequest $request)
    {
        //
        $proveedor = new Proveedor;
        $proveedor->empresa=$request->get('empresa');
        $proveedor->nombre=$request->get('nombre');
        $proveedor->descripcion=$request->get('descripcion');
        $proveedor->telefono=$request->get('telefono');
        $proveedor->correo=$request->get('correo');
        $proveedor->estado='Activo';
  
        $proveedor->save();
        return Redirect::to('local/proveedor');
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
        return view('local.proveedor.show',['proveedor'=>Proveedor::findOrFail($id)]);
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
        return view("local.proveedor.edit",["proveedor"=>Proveedor::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProveedorRequest $request, $id)
    {
         //
         $proveedor = Proveedor::findOrFail($id);
         $proveedor->empresa=$request->get('empresa');
         $proveedor->nombre=$request->get('nombre');
         $proveedor->descripcion=$request->get('descripcion');
         $proveedor->telefono=$request->get('telefono');
         $proveedor->correo=$request->get('correo');
         //$proveedor->estado='1';
   
         $proveedor->update();
         return Redirect::to('local/proveedor');
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
        $proveedor=Proveedor::findOrFail($id);
        $proveedor->estado='Inactivo';
        $proveedor->update();
        return Redirect::to('local/proveedor');
    }
}
