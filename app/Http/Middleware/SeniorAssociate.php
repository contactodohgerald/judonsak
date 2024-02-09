<?php

namespace App\Http\Middleware;

use Closure;

class SeniorAssociate
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
        if ($request->user()->person->level_id < 3) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }
}
