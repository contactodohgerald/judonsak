<?php

namespace App\Http\Middleware;

use Closure;

class Associate
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
        if ($request->user()->person->level_id < 2) {
            abort(403, 'You don\'t have enough permission for this action.');
        }
        
        return $next($request);
    }
}
