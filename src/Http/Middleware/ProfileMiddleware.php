<?php

namespace MoonShine\Spring\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        moonshineConfig()
            ->guard('web')
            ->homeRoute('home');

        return $next($request);
    }
}
