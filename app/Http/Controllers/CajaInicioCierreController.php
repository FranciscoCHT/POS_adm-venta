<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\CajaInicioCierre;
use App\Venta;
use App\DetalleVenta;
use App\Producto;
use DB;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use DateTime;

class CajaInicioCierreController extends Controller
{
    public function index(Request $request)
    {
        $query=trim($request->get('searchText'));
        $caja_inicio_cierre=DB::table('caja_inicio_cierre as c')
        ->join('usuario as u','c.usuario_id','=','u.id')
        ->select('c.id','c.fecha_inicio','c.fecha_cierre','c.dinero_inicio','c.dinero_cierre','c.estado')
        ->where('c.fecha_inicio','LIKE','%'.$query.'%')
        ->orderBy('c.id','desc')
        ->paginate(10);

        return view('local.caja_inicio_cierre.index',["cajas_inicio_cierre"=>$caja_inicio_cierre,"searchText"=>$query]);
    }

    public function create()
    {
        $caja = DB::table('caja_inicio_cierre')->where('estado',1)->exists();
        return view("local.caja_inicio_cierre.create",["caja_abierta"=>$caja]);
    }

    public function store(Request $request)
    {
        $existeActual = DB::table('caja_inicio_cierre')->where('estado', '1')->first();

        if($existeActual == null){
            $fechaActual = new DateTime();
            $caja_inicio_cierre = new CajaInicioCierre;
            $caja_inicio_cierre->fecha_inicio= $fechaActual;
            $caja_inicio_cierre->fecha_cierre= null;
            $caja_inicio_cierre->dinero_inicio= $request->get('dinero_inicio');
            $caja_inicio_cierre->dinero_cierre= null;
            $caja_inicio_cierre->estado = 1;
            $caja_inicio_cierre->usuario_id = Auth::id();
            if($caja_inicio_cierre->save()){
                return Redirect::to('local/caja_inicio_cierre');
            }
        }else{

            return Redirect::to('local/caja_inicio_cierre');
        }
    }

    public function show($id)
    {
    }
    public function movimiento($id)
    {
        //optener cada producto vendido
        $caja_inicio_cierre = DB::table('caja_inicio_cierre')->where('id', $id)->first();
        $producto_vendido = array(); 
        $productoNombre = array();
        $cantidad_producto = array();
        $total_precio_producto = array();
        $total_global = 0;
        //fin
        $ventasCaja = DB::table('venta')->where('caja_inicio_cierre_id', $id)->get();
        $detallesVenta;
        $cantproducto = 0;
        $sinPorudcto = 0;
        if($ventasCaja){
            foreach($ventasCaja as $ventas){
                $detallesVenta = DB::table('detalle_venta')->where('venta_id', $ventas->id)->get();
                foreach($detallesVenta as $leerLinea){
                    if($cantproducto == 0){
                        $producto_vendido[$cantproducto] = $leerLinea->producto_id;
                        $productoNombre[$cantproducto] = DB::table('producto')
                        ->select('nombre')
                        ->where('id',$leerLinea->producto_id)
                        ->first();
                        $cantidad_producto[$cantproducto] = $leerLinea->cantidad;
                        $total_precio_producto[$cantproducto] = $leerLinea->precio_linea;
                        $total_global = $leerLinea->precio_linea;
                        $cantproducto++;
                    }else{
                        for($i=0;$i<$cantproducto;$i++){
                            if($producto_vendido[$i] == $leerLinea->producto_id ){
                                $cantidad_producto[$i] = $cantidad_producto[$i] + $leerLinea->cantidad;
                                $total_precio_producto[$i] = $total_precio_producto[$i] + $leerLinea->precio_linea;
                                $total_global = $total_global + $leerLinea->precio_linea;
                                $sinPorudcto = 1;
                                break;
                            }else{
                                $sinPorudcto = 0;
                            }
                        }
                        if($sinPorudcto == 0){
                            
                            $producto_vendido[$cantproducto] = $leerLinea->producto_id;
                            $productoNombre[$cantproducto] = DB::table('producto')
                            ->select('nombre')
                            ->where('id',$leerLinea->producto_id)
                            ->first();
                            $cantidad_producto[$cantproducto] = $leerLinea->cantidad;
                            $total_precio_producto[$cantproducto] = $leerLinea->precio_linea;
                            $total_global = $total_global+$leerLinea->precio_linea;
                            $cantproducto++;
                        }
                    }
                }
            }
        }
        return view('local.caja_inicio_cierre.movimiento',["productoNombre"=>$productoNombre,"total_global" => $total_global, "total_precio_producto" => $total_precio_producto,"cantidad_producto"=>$cantidad_producto,"cantproducto"=>$cantproducto,"caja_inicio_cierre"=>$caja_inicio_cierre]);
    }

    public function edit($id)
    {
        $caja_inicio_cierre=CajaInicioCierre::findOrFail($id);
        if($caja_inicio_cierre->estado == 1){
            return view("local.caja_inicio_cierre.edit",['caja_inicio_cierre'=>$caja_inicio_cierre]);
        }else{
            return view("local.caja_inicio_cierre.corregir",['caja_inicio_cierre'=>$caja_inicio_cierre]);
        }   
    }

    public function update(Request $request, $id)
    {
        $fechaActual = new DateTime();
        $caja_inicio_cierre=CajaInicioCierre::findOrFail($id);
        $caja_inicio_cierre->fecha_cierre = $fechaActual;
        $caja_inicio_cierre->dinero_cierre = $request->get('dinero_cierre');        
        $caja_inicio_cierre->estado = 0;
        $caja_inicio_cierre->update();
        return Redirect::to('local/caja_inicio_cierre');
    }   

    public function corregir(Request $request, $id)
    {
        $caja_inicio_cierre = CajaInicioCierre::findOrFail($id);
        $caja_inicio_cierre->dinero_cierre = $request->get('dinero_cierre'); 
        $caja_inicio_cierre->update();
        return Redirect::to('local/caja_inicio_cierre');
    }

    public function destroy($id)
    {
    }
}
