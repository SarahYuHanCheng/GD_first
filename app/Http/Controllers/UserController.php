<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Providers\TokenServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $out;
    
    public function __construct()
    {
        $this->out = new \Symfony\Component\Console\Output\ConsoleOutput();
    }
    public function login(Request $request)
    {
        $user1 = $request->user;
        
        $user1->update(['name'=>'sarah']);
        $user1->save();
        $this->out->writeln("loginnnnnn".$user1); 
    }


    public function logout(Request $request)
    {
        
        
        $user1 = User::where('name', $request->input('name'))->first();
        $provider = new TokenServiceProvider;
        $provider->deleteToken($user1);
        return "fin";

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("create");

        $token = Hash::make(Str::random(60));
        User::create([
            'name' => $request->input('name', ''),
            'password' => Hash::make($request->input('password', '')),
            'api_token' => $token,
        ]);
        $data = [
            'api_token' => $token,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("* store *"); 
        return "";
        try {
            $token = hash('sha256', Str::random(60));
            $user = new User(
                [
                    'name' => $request->input('name', ''),
                    'password' => $request->input('password', ''),
                    'api_token' => $token,
                ]
            );
            $user->save();
            $data = [
                'api_token' => $token,
            ];
            
            
            return response()->json($data);
        } catch (\Throwable $th) {
            
            $out->writeln("* store user error *".$th); 
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
