<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Penting: Import Auth
use Carbon\Carbon; // Penting: Import Carbon

class UpdateUserLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $now = Carbon::now();

            if (!$user->last_seen_at || $now->diffInMinutes($user->last_seen_at) >= 5) {
                $user->update(['last_seen_at' => $now]);
            }
        }

        return $next($request);
    }
}
