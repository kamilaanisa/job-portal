<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login DAN bukan admin
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return $next($request);
        }

        // Kalau admin, redirect ke dashboard admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect('/admin')->with('error', 'Halaman ini khusus untuk user biasa.');
        }

        // Kalau belum login, redirect ke login
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }
}