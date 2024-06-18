<?php

namespace App\Http\Middleware;

use App\Facades\MessageFixer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class PublicApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!password_verify(env('APP_KEY', 'THE BAILE APARTMENT'), $request->header('x-baile-token'))) {
            return MessageFixer::warning('Token Invalid.');
        }

        return $next($request);
    }
}
