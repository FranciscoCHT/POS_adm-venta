<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DetalleCompra;
use Illuminate\Support\Facades\Redirect;
use DB;

class DetalleCompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function index(Request $request)
    {
        //
        if($request)
        {
            //SE BUSCA QUE SE MUESTRE LA ULTIMO COMPRA DE UN PRODUCTO
            $detalle_compra_id = DB::table('detalle_compra as d')
            ->select('d.producto_id', DB::raw('MAX(d.id) as maximo ') )
            ->groupBy('d.producto_id');
               
            $query=trim($request->get('searchText'));
            $detalles_compra=DB::table('detalle_compra as de')
                ->joinSub($detalle_compra_id,'detalle_compra_id', function($join){
                    $join->on('de.id','=','detalle_compra_id.maximo');
            })
            ->join('producto as p','de.producto_id','=','p.id')
            ->join('compra as c','de.compra_id','=','c.id')
            ->join('proveedor as pro','c.proveedor_id','=','pro.id')
            ->select('de.id','p.nombre','p.cod_barra','p.imagen','p.precio as precio_venta','c.iva','pro.empresa','de.precio','c.fecha_compra')
            ->where('p.nombre','LIKE','%'.$query.'%')
            ->orwhere('p.cod_barra','LIKE','%'.$query.'%')
            ->orderBy('de.id','desc')
            ->paginate(7);

            //FUNCIONA PERO MUESTRA TODOS LAS COMPRAS DE LOS PRODUCTOS!
            /*
            $query=trim($request->get('searchText'));
            $detalles_compra=DB::table('detalle_compra as de')
            ->join('producto as p','de.producto_id','=','p.id')
            ->join('compra as c','de.compra_id','=','c.id')
            ->join('proveedor as pro','c.proveedor_id','=','pro.id')
            ->select('de.id','p.nombre','p.cod_barra','p.imagen','c.iva','pro.empresa','de.precio','c.fecha_compra')
            ->where('p.nombre','LIKE','%'.$query.'%')
            ->orwhere('p.cod_barra','LIKE','%'.$query.'%')
            ->orderBy('c.id','desc')
            //->paginate(7); */

            return view('local.detalle_compra.index',["detalles"=>$detalles_compra,"searchText"=>$query]);
           
        }

    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
