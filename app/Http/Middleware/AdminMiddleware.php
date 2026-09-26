<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$types): Response
    {
        // По умолчанию доступ только у админа; 'admin:admin,moderator' пускает и модераторов
        $types = $types ?: ['admin'];

        if (! auth()->check() || ! in_array(auth()->user()->type, $types, true)) {
            abort(403);
        }

        return $next($request);
    }
}
