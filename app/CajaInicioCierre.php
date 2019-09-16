<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaInicioCierre extends Model
{
     //
     protected $table='caja_inicio_cierre';

     protected $primaryKey="id";
 
     public $timestamps=false;
 
     protected $fillable=[
         'fecha_inicio',
         'fecha_cierre',
         'dinero_inicio',
         'dinero_cierre',
         'estado',
         'usuario_id',
     ];
 
     protected $guarded =[
         
     ];
}
