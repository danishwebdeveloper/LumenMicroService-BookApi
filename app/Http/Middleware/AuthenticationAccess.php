<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AuthenticationAccess
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
        $validsecrets = explode(',', env('ACCEPTED_SECRET'));

        if (in_array($request->header('Authorization'), $validsecrets)) {
            return $next($request);
        }
        abort(Response::HTTP_UNAUTHORIZED);
    }
}