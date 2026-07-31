<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Periksa apakah pengguna memiliki role 'admin' atau 'superadmin'
        if ($user && in_array($user->role, ['admin', 'superadmin'])) {
            return $next($request); // Lanjutkan ke URL tujuan
        }

        // Jika bukan, arahkan ke URL '/'
        return redirect()->back();
    }
}
