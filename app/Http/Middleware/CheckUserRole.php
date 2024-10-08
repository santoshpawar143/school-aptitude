<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roleName)
    {
        // Fetch the authenticated user with their role
        $user = User::with('role')->find(auth()->id());

        // Check if the user exists and if their role matches the required role
        if ($user && $user->role && $user->role->name === $roleName) {
            return $next($request);
        }

        // Redirect or respond with an error if the role doesn't match
        return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
    }
}
