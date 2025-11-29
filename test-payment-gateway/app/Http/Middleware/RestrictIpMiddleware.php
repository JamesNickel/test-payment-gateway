<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictIpMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = explode(',', env('GATEWAY_ALLOWED_IPS', '127.0.0.1'));

        if (!in_array($request->ip(), $allowedIps)) {
            abort(403, 'Unauthorized IP address.');
        }

        return $next($request);
    }
}
