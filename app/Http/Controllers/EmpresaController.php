<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use App\Empresa;
use DB;
use Illuminate\Support\Collection;





class EmpresaController extends Controller
{
    
    public function index()
    {
        //
        $datos = DB::table('datos_empresa')->first();
        return view('local.empresa.index',["empresa"=>$datos]);
    }

    public function create()
    {
        //
        return view("local.empresa.create");
    }

    public function store(Request $request)
    {
        //
        $empresa = new Empresa;
        $empresa->nombre=$request->get('nombre');
        $empresa->tipo=$request->get('tipo');
        $empresa->direccion= $request->get('direccion');
        $empresa->razon_social=$request->get('razon_social');
        $empresa->comuna=$request->get('comuna');
        //$empresa->logo = $request->get('logo');
        $empresa->save();
        return Redirect::to('local/empresa');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
        $empresa=Empresa::findOrFail($id);
        
        return view("local.empresa.edit",['empresa'=>$empresa]);
    }

    public function update(Request $request, $id)
    {
        //
        $empresa = Empresa::findOrFail($id);
        $empresa->nombre=$request->get('nombre');
        $empresa->tipo=$request->get('tipo');
        $empresa->direccion= $request->get('direccion');
        $empresa->razon_social=$request->get('razon_social');
        $empresa->comuna=$request->get('comuna');
        //$empresa->logo = $request->get('logo');
        $empresa->update();
        return Redirect::to('local/empresa');
    }

    public function destroy($id)
    {
        //
    }
}
