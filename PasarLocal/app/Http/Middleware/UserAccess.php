<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Penting: Import Auth
use Carbon\Carbon;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $userType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $userType): Response
    {
        if (auth()->check() && auth()->user()->role === $userType) {
            Auth::user()->update(['last_seen_at' => Carbon::now()]);
            return $next($request);
        }

        // Jika user tidak memiliki akses, arahkan ke halaman 403
        abort(403, 'Unauthorized access.');
    }
}
