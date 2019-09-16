<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use App\Categoria;

use App\Http\Requests\CategoriaRequest;

use DB;

class CategoriaController extends Controller
{
    public function __construct()
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
             /* Anterior para ambos :P
             $query = trim($request->get('searchText'));
             $categorias = DB::table('categoria')
             ->where('nombre','LIKE','%'.$query.'%')
             ->orderBy('id','desc')
             ->paginate(7);
 
             return view('local.categoria.index',["categorias"=>$categorias,"searchText"=>$query]);
             */
            // Solo activos
            $query = trim($request->get('searchText'));
            $categorias = DB::table('categoria')
            ->where('estado','=','Activo')
            ->where('nombre','LIKE','%'.$query.'%')
            ->orderBy('id','desc')
            ->paginate(7);
 
            return view('local.categoria.index',["categorias"=>$categorias,"searchText"=>$query]);
         }
    }

    public function inactivo(Request $request)
    {
         //Para mostrar inactivos!
         if($request)
         {
             $query = trim($request->get('searchText'));
             $categorias = DB::table('categoria')
             ->where('estado','=','Inactivo')
             ->where('nombre','LIKE','%'.$query.'%')
             ->orderBy('id','desc')
             ->paginate(10);
 
             return view('local.categoria.inactivos',["categorias"=>$categorias,"searchText"=>$query]);
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
        return view("local.categoria.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {
        //
        $categoria = new Categoria;
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->estado='Activo';
        $categoria->sku = $request->get('sku');
  
        $categoria->save();
        return Redirect::to('local/categoria');
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
        return view('local.categoria.show',['categoria'=>Categoria::findOrFail($id)]);
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
        return view("local.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaRequest $request, $id)
    {
        //
        $categoria = Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        //$categoria->estado='1';

        $categoria->update();
        return Redirect::to('local/categoria');
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
        $categoria=Categoria::findOrFail($id);
        $categoria->estado='Inactivo';
        $categoria->update();
        return Redirect::to('local/categoria');
    }
    public function activar($id)
    {
        //
        $categoria=Categoria::findOrFail($id);
        $categoria->estado='Activo';
        $categoria->update();
        return Redirect::to('local/categoria/inactivo');
    }
}
