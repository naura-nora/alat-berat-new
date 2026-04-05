<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (auth()->user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk Petugas.');
        }
        
        return $next($request);
    }
}
