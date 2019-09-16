<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    //
    protected $table='compra';

    protected $primaryKey="id";

    public $timestamps=false;

    protected $fillable=[
    	'fecha_compra',
    	'total_compra',
    	'iva',
        'numero_documento',
        'codigo_barra',
        'tipo_documento',
        'proveedor_id'
    ];

    protected $guarded =[
    	
    ];
}
