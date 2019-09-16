<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    protected $table='producto';

    protected $primaryKey="id";

    public $timestamps=false;

    protected $fillable=[
    	'nombre',
    	'descripcion',
    	'imagen',
        'estado',
        'stock',
    	'porc_ganancia',
        'cod_barra',
        'precio',
        'categoria_id'
    ];

    protected $guarded =[
    	
    ];
}
