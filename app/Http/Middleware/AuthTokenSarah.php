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
    public function handle($request, Closure $next, $role)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("* in auth handle:* ");
        try {
            $credentials = $request->only('remember_token','password');
            if (Auth::attempt($credentials,true)) {
                $out->writeln("* auth ok:* ");
                $request->merge(['user' => Auth::user()]);
            }else {
                $out->writeln("* no remember:* ");
                try {
                    $credentials = $request->only('name', 'password');
                    if (Auth::attempt($credentials,true)) {
                        // Authentication passed...
                        // return redirect()->intended('dashboard');
                        // $provider = new TokenServiceProvider;
                        // $new_token = $provider->updateToken(Auth::user());
                        
                        $request->merge(['user' => Auth::user()]);
                        
                    }else {
                        return response()->json(['result'=>'please login first.'],401);
                    }
                } catch (\Throwable $th) {
                    $out->writeln("* attempt error:* ".$th);
                    return response()->json(['result'=>'wrong name or password.'],401);
                }
            }
            if($role ==  'merchant'){
                if( Auth::user()->role != '1'){
                    return response()->json(['result'=>'Can\'t access the url.'],403);
                }
            }
            
            return $next($request);
        } catch (\Throwable $th) {
            $out->writeln("* first error:* ".$th);
        
        }

        
        // $out->writeln("*pa1* ".$pa1); 

        
    }

    
}
