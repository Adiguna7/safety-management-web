<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        
        if($user->is_admin && $user->role == 'super_admin'){
            return $next($request);
        }        
        else if($user->is_admin && $user->role == 'admin'){
            return $next($request);
        }
        
        return abort(403);
    }
}
