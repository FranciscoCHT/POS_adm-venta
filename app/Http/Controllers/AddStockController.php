<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Auth;
use DB;

use App\AddStock;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class AddStockController extends Controller
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
            $query=trim($request->get('searchText'));
            $adds=DB::table('add_stock as a')
            ->join('usuario as u','a.usuario_id','=','u.id')
            ->join('producto as p','a.producto_id','=','p.id')
            ->select('a.id','a.cantidad','a.fecha','u.nombre as vendedor','p.nombre as producto')
            ->where('u.nombre','LIKE','%'.$query.'%')
            ->orwhere('p.nombre','LIKE','%'.$query.'%')
            ->orderBy('a.id','desc')
            ->paginate(10);

            //Verificar si existe una caja abierta
            $caja = DB::table('caja_inicio_cierre')->where('estado',1)->exists();

            return view('local.addstock.index',["adds"=>$adds,"searchText"=>$query,"caja"=>$caja]);
        }

    }

    public function create()
    {
        //
        $productos=DB::table('producto as p')
        ->select(DB::raw('CONCAT(p.nombre," ",p.cod_barra) as producto'),'p.id','p.nombre','p.descripcion')
        ->where('p.estado','=','Activo')
        ->get();

        return view('local.addstock.create',['productos'=>$productos]);
    }

    
    public function store(Request $request)
    {
        //
        try{
            DB::beginTransaction();
             
            //apertura y cierre de caja 
            $caja_inicio_cierre = DB::table('caja_inicio_cierre')->where('estado','1')->first();
            //fin apertura cierre caja
            
            //Obtiene la fecha actual
            $mytime = Carbon::now('America/Santiago');
            //$venta->fecha_venta=$mytime->toDateTimeString();
            
            $producto_id = $request->get('producto_id');
            $cantidad = $request->get('cantidad');

            $cont = 0;
            
            while($cont < count($producto_id))
            {
                $add_stock = new AddStock;
                $add_stock->producto_id = $producto_id[$cont];
                $add_stock->cantidad = $cantidad[$cont];
                $add_stock->fecha = $mytime->toDateTimeString();
                $add_stock->usuario_id = Auth::id();
                $add_stock->caja_inicio_cierre_id = $caja_inicio_cierre->id;
                $add_stock->save();

                //AUMENTAR EL STOCK
                DB::table('producto')
                ->where('id','=',$add_stock->producto_id)
                ->where('stock','!=',99999)
                ->increment('stock',$add_stock->cantidad);

                $cont=$cont+1;
            }
            
            //SE GUARDAN TODOS LOS DATOS!
            DB::commit();


        }catch(\Exception $e)
        {
            DB::rollback();
            var_dump($e->getMessage());
            exit();
        }
        return Redirect::to('local/add-stock');
    }

    
    public function show($id)
    {
        //Parece ser innecesario
    }

   
    public function edit($id)
    {
        //Pensarlo
    }

   
    public function update(Request $request, $id)
    {
        //Pesarlo
    }

    
    public function destroy($id)
    {
         //
         $add_stock = AddStock::findOrFail($id);
         //DISMINUIR EL STOCK
         DB::table('producto')
         ->where('id','=',$add_stock->producto_id)
         ->where('stock','!=',99999)
         ->decrement('stock',$add_stock->cantidad);
         $add_stock->delete();
         return Redirect::to("local/add-stock");
    }
}
