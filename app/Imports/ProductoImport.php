<?php

namespace App\Imports;

use App\Producto;
use App\Categoria;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $skuAux = $row[8];
        $categoria = Categoria::where('sku',$skuAux)->first();   
        return new Producto([
            //
            'nombre'=> $row[0],
            'descripcion' => $row[1],
            'imagen' => $row[2],
            'estado' => $row[3],
            'stock' => intval($row[4]),
            'porc_ganancia' => floatval($row[5]),
            'cod_barra' => $row[6],
            'precio' => intval($row[7]),
            'categoria_id' => $categoria->id,
        ]);
    }
}
