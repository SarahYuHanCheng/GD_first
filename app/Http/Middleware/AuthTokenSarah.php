<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Str;
use App\Providers\TokenServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthTokenSarah
{
    public function guard()
    {
        return Auth::guard();
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        try {
            if ($this->guard()->user()) {
                $request->merge(['user' => $this->guard()->user()]);
            }else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            if($role ==  'merchant'){
                if( Auth::user()->role != '1'){
                    return response()->json(['error' => 'permission denied to the merchant URL.'], 403);
                }
            }
            
            return $next($request);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 401);
        
        }


        
    }

    
}
