<?php

namespace App\Http\Middleware;

use Closure;

class BusinessDevDepartment
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
        if ($request->user()->person->level_id > 4 || 
            ( ( $request->user()->person->department_id == 5 ||  $request->user()->person->department_id == 1 ) 
            && $request->user()->person->level_id >= 4 )) {
            return $next($request);
        }
            abort(403, 'Unauthorized Access.');
    }
}
