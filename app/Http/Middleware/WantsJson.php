<?php

namespace App\Http\Middleware;

use Closure;

class WantsJson
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
        if(!$request->wantsJson()) {
            return response()->json([
                'error' => [
                    'message' => 'expects application/json Accept header'
                ]
            ], 403);
        }
        return $next($request);
    }
}
