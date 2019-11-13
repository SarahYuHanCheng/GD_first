<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Str;
use App\Providers\TokenServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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


        $validator = Validator::make($request->all(), [
            'name' => 'required|max:15',
            'password' => 'required|max:15',
        ]);
        
        if ($validator->fails()) {
            $out->writeln('failed: '.$validator->messages());
            return response()->json(['result'=>$validator->messages()],406);
        }else {
                
            try {
                $credentials = $request->only('remember_token','password');
                if (Auth::attempt($credentials,true)) {
                    $out->writeln("* auth ok:* ");
                    $request->merge(['user' => Auth::user()]);
                }else {
                    $out->writeln("* no remember:* ");
                    $credentials = $request->only('name', 'password');
                    if (Auth::attempt($credentials,true)) {
                        // Authentication passed...
                        // return redirect()->intended('dashboard');
                        // $provider = new TokenServiceProvider;
                        // $new_token = $provider->updateToken(Auth::user());
                        
                        $request->merge(['user' => Auth::user()]);
                        
                    }else {
                        return response()->json(['result'=>'name or password error.'],401);
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
        }

        
        // $out->writeln("*pa1* ".$pa1); 

        
    }

    
}
