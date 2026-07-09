<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_logged_in') || !session('admin_user_id')) {
            return redirect()->route('admin.login')->with('error', 'Faça login para acessar o painel.');
        }

        return $next($request);
    }
}
