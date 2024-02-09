<?php

namespace App\Http\Middleware;

use Closure;

class HR
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
        if ($request->user()->person->department_id = 8) {
            return $next($request);
        }
        
        abort(403, 'Unauthorized access.');
    }
}
