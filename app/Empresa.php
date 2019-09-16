<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    //
    protected $table='datos_empresa';

    protected $primaryKey="id";

    public $timestamps=false;

    protected $fillable=[
    	'nombre',
    	'tipo',
    	'direccion',
        'razon_social',
        'comuna',
    	'logo',
    ];

    protected $guarded =[
    	
    ];
}
