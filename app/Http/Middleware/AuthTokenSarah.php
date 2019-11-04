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
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $pa1)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("* in handle:* ");
        try {
            $credentials = $request->only('remember_token','password');
            if (Auth::attempt($credentials,true)) {
                $request->merge(['user' => Auth::user()]);
                return $next($request);
            }else {
            
                try {
                    $credentials = $request->only('name', 'password');
                    if (Auth::attempt($credentials,true)) {
                        // Authentication passed...
                        // return redirect()->intended('dashboard');
                        $provider = new TokenServiceProvider;
                        $new_token = $provider->updateToken($request->user);
                        $request->merge(['user' => Auth::user()]);
                        return $next($request);
                    }
                } catch (\Throwable $th) {
                    $out->writeln("* attempt error:* ".$th);
                }
            }
        } catch (\Throwable $th) {
            $out->writeln("* first error:* ".$th);
        
        }

        
        // $out->writeln("*pa1* ".$pa1); 

        
    }

    
}
