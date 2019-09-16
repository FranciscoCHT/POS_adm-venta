<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    //
    protected $table='detalle_venta';

    protected $primaryKey="id";

    public $timestamps=false;

    protected $fillable=[
    	'venta_id',
    	'producto_id',
        'cantidad',
        'precio_linea',
        'precio_unitario',
        'descuento',
        
    ];

    protected $guarded =[
    	
    ];
}
