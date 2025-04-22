<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (!session('is_admin')) {
            return redirect('/')->with('error', 'Akses admin diperlukan');
        }
        return $next($request);
    }
}
