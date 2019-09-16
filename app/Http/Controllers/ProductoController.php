<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use App\Producto;

use App\Http\Requests\ProductoRequest;

use DB;

class ProductoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if($request)
        {
            //Para productos activos
            $query2=trim($request->get('searchText'));        
            $productos = DB::table('producto as p')
            ->join('categoria as c','p.categoria_id','=','c.id')
            ->select('p.id','p.nombre','p.descripcion','p.imagen','p.estado','p.stock',
            'p.cod_barra','p.precio','c.nombre as categoria')
            ->where('p.estado','=','Activo')
            ->when($query2, function ($query, $query2) {
                return $query->where('p.nombre','LIKE','%'.$query2.'%')
                             ->orwhere('p.cod_barra','LIKE','%'.$query2.'%');
            })
            ->orderBy('p.id','desc')
            ->paginate(7);
             
            return view('local.producto.index',["productos"=>$productos,"searchText"=>$query2]);
        }
    }

    public function inactivo(Request $request)
    {
        //
        if($request)
        {
            //Para productos inactivos
            $query2=trim($request->get('searchText'));        
            $productos = DB::table('producto as p')
            ->join('categoria as c','p.categoria_id','=','c.id')
            ->select('p.id','p.nombre','p.descripcion','p.imagen','p.estado','p.stock',
            'p.cod_barra','p.precio','c.nombre as categoria')
            ->where('p.estado','=','Inactivo')
            ->when($query2, function ($query, $query2) {
                return $query->where('p.nombre','LIKE','%'.$query2.'%')
                             ->orwhere('p.cod_barra','LIKE','%'.$query2.'%');
            })
            ->orderBy('p.id','desc')
            ->paginate(7);
             
            return view('local.producto.inactivo',["productos"=>$productos,"searchText"=>$query2]);
            
        }
    }

    public function create()
    {
        //
        $categorias = DB::table('categoria')->where('estado','=','Activo')->get();
        return view("local.producto.create",['categorias'=>$categorias]);
    }

    public function store(ProductoRequest $request)
    {
        //
        $producto = new Producto;
        $producto->nombre=$request->get('nombre');
        $producto->descripcion=$request->get('descripcion');
        $producto->estado='Activo';
        
        //$producto->cod_barra=$request->get('cod_barra');
        $producto->precio=$request->get('precio');
        $producto->categoria_id=$request->get('categoria_id');
        $stock_producto = $request->get('stock');
        //COMPROBAR SI STOCK VIENE VACIO 
        if($stock_producto)
        {   
           if($stock_producto == 99999)
           {
            /** Obtengo el id del ultimo producto con stock 99999 */
            $id_ultimo = DB::table('producto')
                        ->select(DB::raw('MAX(id) as id'))
                        ->where('stock','=',99999)
                        ->first();
            /** Obtengo la información */
            $producto_ultimo = DB::table('producto')
                            ->where('id','=',$id_ultimo->id)
                            ->first();
            if(!$producto_ultimo){
                $producto->cod_barra=3330001;
            }
            else{
                $producto->cod_barra = $producto_ultimo->cod_barra+1;
            }
           }else{
                $producto->cod_barra=$request->get('cod_barra');
                $producto->stock=$stock_producto;
           }
          
        }else{
            $producto->stock=0;
            $producto->cod_barra=$request->get('cod_barra');
        }
        
        if(Input::hasFile('imagen')){
            $file=Input::file('imagen');
            $file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
            $producto->imagen=$file->getClientOriginalName();
        }
        $producto->save();
        return Redirect::to('local/producto');
    }

    public function show($id)
    {
        //
        return view('local.producto.show',['producto'=>Producto::findOrFail($id)]);
    }

    public function edit($id)
    {
        //
        $producto=Producto::findOrFail($id);
        $categorias=DB::table('categoria')->where('estado','=','Activo')->get();
        return view("local.producto.edit",['producto'=>$producto,'categorias'=>$categorias]);
    }

    public function update(Request $request, $id)
    {
        //
        $producto = Producto::findOrFail($id);
        $producto->nombre=$request->get('nombre');
        $producto->descripcion=$request->get('descripcion');
        //$producto->estado='Activo';
        $producto->stock=$request->get('stock');
        //$producto->porc_ganancia=$request->get('porc_ganancia');
        $producto->cod_barra=$request->get('cod_barra');
        $producto->precio=$request->get('precio');
        $producto->categoria_id=$request->get('categoria_id');

        if(Input::hasFile('imagen')){
            $file=Input::file('imagen');
            $file->move(public_path().'/imagenes/productos/',$file->getClientOriginalName());
            $producto->imagen=$file->getClientOriginalName();
        }

        $producto->update();
        return Redirect::to('local/producto');
    }

    public function destroy($id)
    {
        //
        $producto=Producto::findOrFail($id);
        $producto->estado='Inactivo';
        $producto->update();
        return Redirect::to('local/producto');
    }

    public function activar($id)
    {
        //
        $producto=Producto::findOrFail($id);
        $producto->estado='Activo';
        $producto->update();
        return Redirect::to('local/producto/inactivo');
    }
}
