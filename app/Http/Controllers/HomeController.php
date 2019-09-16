<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;


use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function inicio()
    {
        //APLICAR LOGICA DE DATOS!
        $fecha_actual = Carbon::now('America/Santiago')->format('Y-m-d');


        //COMPRAS REALIZADA A UN PROVEEDOR
        $compra_proveedor = DB::table('compra as c')
        ->join('proveedor as p','c.proveedor_id','=','p.id')
        ->select('p.empresa',DB::raw('SUM(c.total_compra) as total_compra') )
        ->groupBy('p.empresa')
        ->take(4)
        ->get();
        //PRODUCTOS MAS COMPRADOS
        $producto_compra = DB::table('producto as pro')
        ->join('detalle_compra as de','pro.id','=','de.producto_id')
        ->select('pro.nombre',DB::raw('SUM(de.total_linea) as total') )
        ->groupBy('pro.nombre')
        ->take(4)
        ->get();
         //OBTENER CANTIDAD DE DINERO SALIENTE (Momentaneo)
         $dinero_saliente = DB::table('compra')
         ->select(DB::raw('SUM(total_compra) as total'))
         ->whereDate('fecha_compra',$fecha_actual)
         ->get();
        //OBTENER LOS DATOS DE LA APERTURA DE CAJA ACTIVA
        $caja = DB::table('caja_inicio_cierre')
                ->where('estado',1)
                ->first();
        if($caja){ 
            //OBTENER CANTIDAD VENTAS DE HOY
            $egreso_agil = DB::table('egreso')
                            ->select(DB::raw('SUM(monto) as total'))
                            ->where('caja_inicio_cierre_id',$caja->id)
                            ->get();
            //OBTENER CANTIDAD DE DINERO ENTRANTE
            $dinero_entrante = DB::table('venta')
                            ->select(DB::raw('SUM(precio_total) as total'))
                            ->where('caja_inicio_cierre_id',$caja->id)
                            ->get();
        }else{
            $egreso = 0;
            $caja = 0;
            $dinero_entrante = 0;
            return view('local.inicio.panel',["compra_pro"=>$compra_proveedor,
            'producto_compra'=>$producto_compra,'dinero_caja'=>$caja,'egreso'=>$egreso,
            'dinero_entrante'=>$dinero_entrante,'dinero_saliente'=>$dinero_saliente[0]->total]);
        }
        
        return view('local.inicio.panel',["compra_pro"=>$compra_proveedor,
        'producto_compra'=>$producto_compra,'dinero_caja'=>$caja->dinero_inicio,'egreso'=>$egreso_agil[0]->total,
        'dinero_entrante'=>$dinero_entrante[0]->total,'dinero_saliente'=>$dinero_saliente[0]->total]);
    }
}
