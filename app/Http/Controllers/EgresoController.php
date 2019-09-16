<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

use App\Egreso;
use DB;

class EgresoController extends Controller
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
            $egresos=DB::table('egreso as e')
            ->join('usuario as u','e.usuario_id','=','u.id')
            ->select('e.id','e.monto','e.comentario','e.fecha','u.nombre as vendedor')
            ->where('u.nombre','LIKE','%'.$query.'%')
            ->orwhere('e.fecha','LIKE','%'.$query.'%')
            ->orderBy('e.id','desc')
            ->paginate(10);

            //Verificar si existe una caja abierta
            $caja = DB::table('caja_inicio_cierre')->where('estado',1)->exists();

            return view('local.egreso.index',["egresos"=>$egresos,"searchText"=>$query,"caja"=>$caja]);
        }

    }

    public function create()
    {
        //
        return view('local.egreso.create');
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
            
            $monto = $request->get('monto');
            $comentario = $request->get('comentario');

            $cont = 0;
            
            while($cont < count($monto))
            {
                $egreso = new Egreso;
                $egreso->monto = $monto[$cont];
                $egreso->comentario = $comentario[$cont];
                $egreso->fecha = $mytime->toDateTimeString();
                $egreso->usuario_id = Auth::id();
                $egreso->caja_inicio_cierre_id = $caja_inicio_cierre->id;
                $egreso->save();

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
        return Redirect::to('local/egreso');
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
        $egreso=Egreso::findOrFail($id);
        $egreso->delete();
        return Redirect::to("local/egreso");
    }
}
