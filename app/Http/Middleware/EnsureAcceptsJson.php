<?php

namespace App\Http\Middleware;

use App\Exceptions\AcceptTypeException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAcceptsJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->expectsJson())
            return $next($request);

        return response()->json([
            'error' => [
                'status' => 400,
                'title' => "Accept header must be application/json.",
            ],
        ], 400);
    }
}
