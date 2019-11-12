<?php

namespace App\Http\Middleware;

use Closure;
use log;

class TerceiroMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $nome, $idade)
    {
        Log::debug("Passou pelo terceiro middleware [ nome = $nome , $idade]");
        return $next($request);
    }
}
