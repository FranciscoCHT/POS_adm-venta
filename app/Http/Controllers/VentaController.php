<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Venta;
use App\CajaInicioCierre;
use App\DetalleVenta;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

//NECESARIO PARA UTILIZAR LA LIBRERIA DE LA IMPRESORA TERMICA
require __DIR__ . '/../../../vendor/mike42/escpos-php/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if($request)
        {
            $query=trim($request->get('searchText'));
            $ventas=DB::table('venta as v')
            ->join('usuario as u','v.usuario_id','=','u.id')
            ->select('v.id','v.fecha_venta','v.precio_total','v.numero_venta','v.estado','u.nombre as vendedor')
            ->where('u.nombre','LIKE','%'.$query.'%')
            ->orwhere('v.numero_venta','LIKE','%'.$query.'%')
            //->orwhere('p.empresa','LIKE','%'.$query.'%')
            ->orderBy('v.id','desc')
            ->paginate(10);
            return view('local.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
        }
    }

    public function create()
    {
        $productos=DB::table('producto as p')
        ->select(DB::raw('CONCAT(p.nombre," ",p.cod_barra) as producto'),'p.id','p.stock','p.precio','p.nombre')
        ->where('p.estado','=','Activo')
        ->where('p.stock','>','0')
        ->get();

        $datos_empresa = DB::table('datos_empresa')
        ->first();
        return view('puntoventa.venta_pos.create',['productos'=>$productos,'datos_empresa'=>$datos_empresa]);
    }

    public function store(Request $request)
    {
        //
        try{
            DB::beginTransaction();
             
            $venta=new Venta;
            $venta->precio_total=$request->get('precio_total');
            //OPCION 1 ES TRAER LA ULTIMA VENTA POR EL ULTIMO ID!
            /** Obtengo el id de la ultima venta */
            $id_ultimo = DB::table('venta')
            ->select(DB::raw('MAX(id) as id'))
            ->first();
            /** Obtengo la información */
            $venta_ultimo = DB::table('venta')
            ->where('id','=',$id_ultimo->id)
            ->first();
            
            if(!$venta_ultimo){
                $venta->numero_venta=1110001;
                $venta->cod_barra=9990001;
            }
            else{
                $venta->numero_venta= $venta_ultimo->numero_venta+1;
                $venta->cod_barra=$venta_ultimo->cod_barra+1;
            }
            $venta->estado='Activo';

            //apertura y cierre de caja 
            $venta->usuario_id=Auth::id();
            $caja_inicio_cierre = DB::table('caja_inicio_cierre')->where('estado','1')->first();
            //fin apertura cierre caja
            
            $venta->caja_inicio_cierre_id = $caja_inicio_cierre->id;

            //Obtiene la fecha actual
            $mytime = Carbon::now('America/Santiago');
            $venta->fecha_venta=$mytime->toDateTimeString();
            $venta->save();

            $producto_id = $request->get('producto_id');
            $cantidad = $request->get('cantidad');
            $precio_unitario = $request->get('precio_unitario');
            $precio_linea = $request->get('precio_linea');
            $descuento = $request->get('descuento');

            // Datos para el ticket - impresion
            $pago_entrante = $request->get('pago');
            $vuelto = $pago_entrante - $venta->precio_total;

            $cont = 0;
            
            while($cont < count($producto_id))
            {
                $detalle_venta = new DetalleVenta;
                $detalle_venta->venta_id = $venta->id;
                $detalle_venta->producto_id = $producto_id[$cont];
                $detalle_venta->cantidad = $cantidad[$cont];
                $detalle_venta->precio_unitario = $precio_unitario[$cont];
                $detalle_venta->precio_linea = $precio_linea[$cont];
                $detalle_venta->descuento = $descuento[$cont];
                $detalle_venta->save();

                //DECREMENTAR EL STOCK
                DB::table('producto')
                ->where('id','=',$detalle_venta->producto_id)
                ->where('stock','!=',99999)
                ->decrement('stock',$detalle_venta->cantidad);

                $cont=$cont+1;
            }
            
            //SE GUARDAN TODOS LOS DATOS!
            DB::commit();

            //LOGICA PARA REALIZAR LA IMPRESION DEL TICKET
            /** Conexión de la impresora */
            $nombre_impresora = "POS-58"; 
            $connector = new DummyPrintConnector();

            $table = array(
                'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'È'=>'E', 'É'=>'E', 
                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',   // Tabla para sustituir
                'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'à'=>'a', 'á'=>'a',   // los caracteres con tilde
                'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e',   // y ñ a símbolos legibles.
                'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o',
                'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'ñ'=>'{', 'Ñ'=>'}'
            );
            $tableN = array(
                '{'=>'ñ', '}'=>'Ñ' // Tabla para volver los símbolos a ñ/Ñ y enviar devuelta al cliente.
            );

            $printer = new Printer($connector);
            // Vamos a alinear al centro lo próximo que imprimamos
            $printer->setJustification(Printer::JUSTIFY_CENTER);

            //Obtener los datos de la empresa para imprimir
            $empresa = DB::table('datos_empresa')->first();
            /*  Ahora vamos a imprimir un encabezado
            */
            $printer->text(strtr($empresa->tipo, $table). "\n");
            $printer->text(strtr($empresa->nombre, $table). "\n");
            $printer->text(strtr($empresa->direccion, $table). "\n");
            $printer->text(strtr($empresa->comuna, $table)."\n");
            $printer->text("Numero de detalle ". $venta->numero_venta. "\n");
            #La fecha también
            $printer->text(date("d-m-Y H:i:s") . "\n");
            //$printer->text("\n");
            //$printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("--------------------\n");

            /** Imprimir productos  */
            //$productos_vendidos = DetalleVenta::where('venta_id',$venta->id)->get();
            $productos_vendidos = DB::table('detalle_venta as d')
            ->join('producto as p','d.producto_id','p.id')
            ->select('p.nombre','d.cantidad','d.precio_linea','d.precio_unitario','d.descuento')
            ->where('d.venta_id','=',$venta->id)
            ->get();
            $total = 0;
            foreach ($productos_vendidos as $producto) {
                $total += $producto->cantidad * ($producto->precio_unitario - $producto->descuento);
             
                /*Alinear a la izquierda para la cantidad y el nombre*/
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text($producto->cantidad . " x $" . number_format($producto->precio_unitario,0,',','.'). " ". strtr($producto->nombre, $table) ."\n");
                /*Y a la derecha para el importe*/
                $printer->setJustification(Printer::JUSTIFY_RIGHT);
                $printer->text(' $' . number_format($producto->cantidad * ($producto->precio_unitario - $producto->descuento),0,',','.') . "\n");
            }   
            /*  Terminamos de imprimir los productos, ahora va el total
            */
            $printer->text("-------------\n");
            $printer->text("TOTAL: $". number_format($total,0,',','.') ."\n");
            $printer->text("\n");

            /**  Paga y vuelto */
            $printer->text("Paga con $". number_format($pago_entrante,0,',','.') ."\n");
            $printer->text("Vuelto: $". number_format($vuelto,0,',','.') ."\n");
            /* Podemos poner también un pie de página
            */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Muchas gracias por su compra.\n");
            $printer->text("\n");

            $printer->text("\n");
            $printer->text("\n");
            $printer->text("\n");
           
            /*Alimentamos el papel 3 veces*/
            //$printer->feed(3);
            /*  Cortamos el papel. Si nuestra impresora no tiene soporte para ello, no generará
                ningún error
            */
            $printer->cut();
            /*  Por medio de la impresora mandamos un pulso. Esto es útil cuando la tenemos conectada
                por ejemplo a un cajón
            */
            $printer->pulse();
            /*  Para imprimir realmente, tenemos que "cerrar" la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
            */
            $data = strtr($connector -> getData(), $tableN);
            //$data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
            $printer->close();

        }catch(\Exception $e)
        {
            DB::rollback();
            //var_dump($e->getMessage());
            //exit();
        }
        return $data;//response()->json($data);
    }

    public function show($id)
    {
        //
        $venta=DB::table('venta as v')
        ->join('usuario as u','v.usuario_id','=','u.id')
        ->select('v.id','v.fecha_venta','v.precio_total','v.numero_venta','v.estado','u.nombre as vendedor')
        ->where('v.id','=',$id)
        ->first();

        $detalles=DB::table('detalle_venta as d')
        ->join('producto as p','d.producto_id','=','p.id')
        ->select('p.nombre as producto','d.cantidad','d.precio_unitario','d.precio_linea','d.descuento')
        ->where('d.venta_id','=',$id)
        ->get();

        return view("local.venta.show",["venta"=>$venta,"detalles"=>$detalles]);
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
        $venta=Venta::findOrFail($id);
        $venta->estado='Inactivo';
        $venta->update();
        return Redirect::to("local/venta");
    }
}
