<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
            // Redirect to appropriate dashboard based on user's role
            return match($userRole) {
                'admin'  => redirect()->route('admin.dashboard'),
                'guru'   => redirect()->route('guru.dashboard'),
                'siswa'  => redirect()->route('siswa.dashboard'),
                'satpam' => redirect()->route('satpam.dashboard'),
                'user'   => redirect()->route('siswa.dashboard'), // legacy alias
                default  => redirect()->route('landing'),
            };
        }

        return $next($request);
    }
}
