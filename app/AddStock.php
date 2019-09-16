<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddStock extends Model
{
    //
    protected $table='add_stock';

    protected $primaryKey="id";

    public $timestamps=false;

    protected $fillable=[
        'cantidad',
        'fecha',
        'usuario_id',
        'producto_id',
        'caja_inicio_cierre_id',
    ];

    protected $guarded =[

    ];
}
