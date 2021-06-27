<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class checkAuth
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
        if($request->hasHeader('api_token') && $request->hasHeader('user_id'))
        {

            $user = User::where('id','=',intval($request->header('user_id')))->get()->first();
            if($user instanceof User){

                if($user->api_token != $request->header('api_token')){

                    return response()->json(['error'=>'No tienes permisos para hacer eso'], 401);
                }

            } else {
                return response()->json(['error'=>'No tienes permisos para hacer eso'], 401);
            }

        } else {
            return response()->json(['error'=>'No tienes permisos para hacer eso'], 401);
        }
        return $next($request);
    }
}
