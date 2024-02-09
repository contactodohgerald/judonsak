<?php

namespace App\Http\Middleware;

use Closure;

class Partners
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->person->level_id < 4) {
            abort(403, 'You don\'t have enough permission for this action.');
        }
        return $next($request);
    }
}
