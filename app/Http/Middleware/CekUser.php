<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Pastikan user sudah login
        if (!$user) {
            return redirect()->route('login');
        }

        // Cek role user
        if ($user && in_array($user->role, ['admin', 'superadmin'])) {
            return $next($request); // Lanjutkan ke URL tujuan
        } elseif ($user->role === 'premium' && $user->hasActivePremium()) {
            return $next($request);
        }

        return redirect()->back();
    }
}
