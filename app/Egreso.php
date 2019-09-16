<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
     //
     protected $table='egreso';

     protected $primaryKey="id";
 
     public $timestamps=false;
 
     protected $fillable=[
         'monto',
         'comentario',
         'fecha',
         'usuario_id',
         'caja_inicio_cierre_id',
     ];
 
     protected $guarded =[
         
     ];
}
