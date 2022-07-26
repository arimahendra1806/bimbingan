<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (in_array($request->user()->role,$roles)) {
            //request boleh dilanjutkan
            return $next($request);
        }
        // else {
        //     //jika role tidk sesuai, redirect ke route rejectrole
        //     return redirect('/reject');
        // }
    }
}
