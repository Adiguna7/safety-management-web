<?php

namespace App\Http\Middleware;

use Closure;
use App\SurveyResponse;
use Illuminate\Support\Facades\Auth;

class CekSudahIsi
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
        $response = SurveyResponse::where('user_id', $user->id)->get()->first();
        
        if($response === null){
            return $next($request);
        }        
        else{
            return redirect('user/dashboard');
        }
    }
}
