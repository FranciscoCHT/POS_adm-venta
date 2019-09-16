<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redirect;

use App\CajaInicioCierre;

use Closure;

class autorizaVenta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $caja = CajaInicioCierre::where('estado',1)->first();
        if($caja == null)
        {
            return Redirect::to('/local/caja_inicio_cierre');

        }else{
            return $next($request);
        }
        
    }
}
