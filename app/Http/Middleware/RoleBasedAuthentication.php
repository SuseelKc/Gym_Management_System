<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {

        $user = Auth::user();

        // Check if user is authenticated if not then goes to login
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user's role is included in the allowed roles
        if (in_array($user->UserRole, $roles)) {
            return $next($request);
        }

        // return redirect('/')->with('error', 'Unauthorized access.');
        return redirect()->back();
    }
}
