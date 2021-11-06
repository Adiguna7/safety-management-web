<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class User
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
        if(!$user->is_admin && $user->role == "user"){            
            return $next($request);
        }        
        else if(!$user->is_admin && $user->role == "user_perusahaan"){            
            return $next($request);
        }        
        return abort(403);        
    }
}
