<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Magic;
use App\Models\UserMagic;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use DB;

class UserMagicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //list the magic that user have
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user->only('name','balance');
        $validator = Validator::make($request->all(), [
            'magic_id' => 'required|max:3',
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>$validator->messages(),'user'=>$user],406);
        }else {
            $magics = Magic::where('id',$request->magic_id)->select('id','name','price','level')->get();
        // $magics = Magic::whereIn('id',$request->magics)->select('id','name','price','level')->get();
        if($request->user->balance >= $magics->sum('price')){
            $request->user->balance -= $magics->sum('price');
            try {
                DB::beginTransaction();
                $request->user->save();
                $transaction = Transaction::create([
                    'user_id' => $request->user->id,
                    'shop_id' => $request->shop_id,
                    'detial' => $magics,
                ]);

                UserMagic::create([
                            'user_id' => $request->user->id,
                            'magic_id' => $request->magic_id,
                            'transaction_id' => $transaction->id,
                        ]);
                
                DB::commit();
                return response()->json(['result'=>"Created",'user'=>$user,'shop'=>$request->shop_id,'magics'=>$magics],201);
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['result'=>"Database error",'user'=>$user],507);
            }
        }
            // foreach($magics as $magic){
            //     UserMagic::create([
            //         'user_id' => $request->user->id,
            //         'magic_id' => $magic->id,
            //         'transaction_id' => $transaction->id,
            //     ]);
            // }
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
