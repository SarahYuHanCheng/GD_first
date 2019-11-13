<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Providers\TokenServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
class UserController extends Controller
{
    private $out;
    
    public function __construct()
    {
        $this->out = new \Symfony\Component\Console\Output\ConsoleOutput();
    }
    public function login(Request $request)
    {
        return response()->json(['result'=>'ok','user'=>$request->user->only('name','balance')],200);
    }


    public function logout(Request $request)
    {
        
        
        $user1 = User::where('name', $request->input('name'))->first();
        $provider = new TokenServiceProvider;
        $provider->deleteToken($user1);
        return response()->json(['result'=>'OK'],200);

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
        $out->writeln("store".$request->role);

        $token = Hash::make(Str::random(60));
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:15',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            $out->writeln('failed: '.$validator->messages());
            return response()->json(['result'=>$validator->messages()],406);
        }else {
            try {
                DB::beginTransaction();

                $user =User::create([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'role'=>$request->role,
                ]);
                
                DB::commit();
                return response()->json(['result'=>"Created",'user'=>$user->only('name','balance')],201);

            } catch(Exception $exception){
                DB::rollback();
                $out->writeln('exception'.$exception);
                return response()->json(['result'=>"Database error",],507);
            }
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
    public function update(Request $request)
    {
        $request->user->balance += 100;
        $request->user->save();
        return response()->json(['result'=>'OK','user'=>$request->user->only('name','balance')],200);
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
