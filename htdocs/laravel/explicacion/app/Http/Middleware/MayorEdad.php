<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MayorEdad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $mayor): Response
    {
        if($request->edad < $mayor){
            //return redirect()->route('home');
            //return redirect('/');
            return to_route('home');
        }
        return $next($request);
    }
}
