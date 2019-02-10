<?php

namespace App\Http\Middleware;

use Closure;

class CompanieMiddleware
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
        if(auth()->user()->role->type=="provee"){
            return $next($request);  
        }
        abort(401,"Sin permisos, sección solo para los proveedores");
    }
}
