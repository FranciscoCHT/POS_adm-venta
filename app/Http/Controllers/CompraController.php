<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;


use App\Http\Requests\CompraRequest;

use App\Compra;
use App\DetalleCompra;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;


class CompraController extends Controller
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
            $compras=DB::table('compra as c')
            ->join('proveedor as p','c.proveedor_id','=','p.id')
            ->select('c.id','c.numero_documento','c.fecha_compra','c.total_compra','c.tipo_documento','c.codigo_barra','p.empresa as proveedor')
            ->where('c.codigo_barra','LIKE','%'.$query.'%')
            ->orwhere('p.empresa','LIKE','%'.$query.'%')
            ->orderBy('c.id','desc')
            ->paginate(7);

            return view('local.compra.index',["compras"=>$compras,"searchText"=>$query]);
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
        $proveedores=DB::table('proveedor')->where('estado','=','Activo')->get();

        //Anterior
        //$productos=DB::table('producto')->where('estado','=','Activo')->get();
        //Nueva versión
        $productos=DB::table('producto as p')
        ->select(DB::raw('CONCAT(p.nombre," ",p.cod_barra) as producto'),'p.id','p.stock','p.precio','p.nombre')
        ->where('p.estado','=','Activo')
        ->get();

        return view("local.compra.create",['proveedores'=>$proveedores,'productos'=>$productos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompraRequest $request)
    {
        // Para capturar las excepciones por algun error
        try{
            DB::beginTransaction();
             $compra=new Compra;
             //$compra->fecha_compra=$request->get('fecha_compra');
             $compra->total_compra=$request->get('total_compra');
             $compra->iva=$request->get('iva');
             $compra->numero_documento=$request->get('numero_documento');
             $compra->proveedor_id=$request->get('proveedor_id');
             $compra->codigo_barra=$request->get('codigo_barra');
             $compra->tipo_documento=$request->get('tipo_documento');
             $mytime = Carbon::now('America/Santiago');
             $compra->fecha_compra=$mytime->toDateTimeString();
             $compra->save();

             $producto_id = $request->get('producto_id');
             $cantidad = $request->get('cantidad');
             $precio = $request->get('precio');
             $total_linea = $request->get('total_linea');

            $cont = 0;

            while($cont < count($producto_id))
            {
                $detalle_compra = new DetalleCompra;
                $detalle_compra->compra_id = $compra->id;
                $detalle_compra->producto_id= $producto_id[$cont];
                $detalle_compra->cantidad = $cantidad[$cont];
                $detalle_compra->precio = $precio[$cont];
                $detalle_compra->total_linea = $total_linea[$cont];
                $detalle_compra->save();
                //Incrementar Stock
                DB::table('producto')
                ->where('id','=',$detalle_compra->producto_id)
                ->where('stock','!=',99999)
                ->increment('stock',$detalle_compra->cantidad);

                $cont=$cont+1;
            }

            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
        }
        return Redirect::to('local/compra');
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
        $compra=DB::table('compra as c')
        ->join('proveedor as p','c.proveedor_id','=','p.id')
        ->select('c.id','c.numero_documento','c.fecha_compra','c.total_compra','c.iva','p.empresa')
        ->where('c.id','=',$id)
        ->first();

        $detalles=DB::table('detalle_compra as d')
        ->join('producto as p','d.producto_id','=','p.id')
        ->select('p.nombre as producto','d.cantidad','d.precio','d.total_linea')
        ->where('d.compra_id','=',$id)
        ->get();
        
        $neto=0;
        foreach($detalles as $deta)
        {
            $neto = $neto + $deta->total_linea;
        }

        return view("local.compra.show",["compra"=>$compra,"detalles"=>$detalles,'neto'=>$neto]);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //obtengo los detalles de la compra
        $detalles = DB::table('detalle_compra')
        ->where('compra_id','=',$id)
        ->get();

        //proceso a eliminar los detalles
        foreach($detalles as $deta){
            DB::table('producto')
                ->where('id','=',$deta->producto_id)
                ->where('stock','!=',999)
                ->decrement('stock',$deta->cantidad);
            //$deta->delete();
            DB::Table('detalle_compra')->where('id','=',$deta->id)->delete(); 
        }

        //elimino la compra
        DB::Table('compra')->where('id','=',$id)->delete();
        //$compra=Compra::findOrFail($id);
        //$compra->delete();
        return Redirect::to("local/compra");
        
    }
}
