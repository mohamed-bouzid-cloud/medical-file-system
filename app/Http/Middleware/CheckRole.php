<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login', ['role' => $role]);
        }
    
        $user = Auth::user();
    
        // Use the role attribute from the model
        if ($user->role !== $role) {
            abort(403, 'Unauthorized');
        }
    
        return $next($request);
    }
    
}
