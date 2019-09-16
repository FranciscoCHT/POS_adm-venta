<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UsuarioRequest;
use DB;

class UsuarioController extends Controller
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
            $query=trim($request->get('searchText'));
            $usuarios = DB::table('usuario')
            ->where('nombre','LIKE','%'.$query.'%')
            ->orderBy('id','desc')
            ->paginate(7);

            return view('local.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]);
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
        return view("local.usuario.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        //
        $usuario = new User;
        $usuario->nombre=$request->get('nombre');
        $usuario->apellido=$request->get('apellido');
        $usuario->rut=$request->get('rut');
        $usuario->rol='Vendedor';
        $usuario->telefono=$request->get('telefono');
        $usuario->email=$request->get('email');
        $usuario->password=bcrypt($request->get('password'));
       
        $usuario->save();
        return Redirect::to('local/usuario');
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
        return view('local.usuario.show',['usuario'=>User::findOrFail($id)]);
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
        return view("local.usuario.edit",['usuario'=>User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request, $id)
    {
        //
        $usuario = User::findOrFail($id);
        $usuario->nombre=$request->get('nombre');
        $usuario->apellido=$request->get('apellido');
        $usuario->rut=$request->get('rut');
        $usuario->rol=$request->get('rol');
        $usuario->telefono=$request->get('telefono');
        $usuario->email=$request->get('email');
        $usuario->password=bcrypt($request->get('password'));
       
        $usuario->update();
        return Redirect::to('local/usuario');
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
        $usuario = DB::Table('usuario')->where('id','=',$id)->delete();
        return Redirect::to('local/usuario');
    }
}
