<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Str;
use App\Providers\TokenServiceProvider;

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
        
        $user_name = $request->input('name');
        $user1=User::where('name',$user_name)->first();
        if ($request->input('api_token')){
            if($request->input('api_token') == $user1->api_token){
                    $out->writeln("*bingo* "); 
                    return $next($request);
            }else{
                    $provider = new TokenServiceProvider;
                    $new_token = $provider->updateToken($user1);
                    $out->writeln("*reset token* ");
                    return $next($request);
            }
       }else {
        $out->writeln("*no token* ");
        return redirect('api/home');
       }
    
        
        // $out->writeln("*pa1* ".$pa1); 

        
    }

    
}
