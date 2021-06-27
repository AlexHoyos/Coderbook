<?php

namespace App\Http\Middleware;

use Closure;

class ValidRequestJson
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

        if($request->isJson()){

            return $next($request);

        } else {

            return response()->json(['error'=>'Se esperaba que la peticion sea en application/json']);

        }

    }
}
