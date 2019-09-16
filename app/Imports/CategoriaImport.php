<?php

namespace App\Imports;

use App\Categoria;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoriaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Categoria([
            //
            'nombre'=> $row[0],
            'descripcion' => $row[1],
            'estado' => $row[2],
            'sku' => $row[3],
            
        ]);
    }
}
