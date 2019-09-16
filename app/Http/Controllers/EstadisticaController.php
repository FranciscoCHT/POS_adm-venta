<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;


use App\Imports\ProductoImport;
use App\Imports\CategoriaImport;
use Maatwebsite\Excel\Facades\Excel;

use DB;

class EstadisticaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mostrar_compra(Request $request){

        if($request){
            $query=trim($request->get('searchText'));
            $fecha_inicio=trim($request->get('fecha_inicio'));
            $fecha_termino=trim($request->get('fecha_termino'));

            $compras = DB::table('compra as c')
            ->select('fecha_compra',DB::raw('SUM(total_compra) as total'))
            ->groupBy('fecha_compra')
            ->whereBetween('fecha_compra',[$fecha_inicio,$fecha_termino]) // pesca valor absoluto
            ->get();
            /*
            var_dump($compras);
            exit();
            */

            return view('local.estadistica.compras',["compras"=>$compras,"searchText"=>$query]);
        }

    }
    //todavia no funciona
    public function mostrar_venta(){
        return view('local.estadistica.ventas');
    }

    public function importar_excel_producto(){
        return view('local.estadistica.import_excel');
    }

    public function importar_datos(Request $request){
        Excel::import(new ProductoImport, $request->file('file'));
        //return view('local.estadistica.import_excel');
        //return 'hola';
        return view('local.estadistica.import_excel');
    }

    public function importar_excel_categoria(){
        return view('local.estadistica.importar_categoria');
    }

    public function importar_categoria(Request $request){
        Excel::import(new CategoriaImport, $request->file('file'));
        //return view('local.estadistica.import_excel');
        //return 'hola_categoria';
        return view('local.estadistica.importar_categoria');
}
}
