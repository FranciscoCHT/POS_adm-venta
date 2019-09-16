<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //
    protected $table='venta';

    protected $primaryKey="id";

    public $timestamps=false;

    protected $fillable=[
    	'fecha_venta',
    	'precio_total',
    	'numero_venta',
        'cod_barra',
        'estado',
        'usuario_id'
    ];

    protected $guarded =[
    	
    ];
}
