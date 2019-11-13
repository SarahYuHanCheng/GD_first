<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopMagic;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;
use DB;
class ShopMagicController extends Controller
{
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
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|integer|max:15',
            'user_id' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['result'=>$validator->messages()],406);
        }else {
            $user=$request->user->only('name','balance');
            $user_id = Shop::where(['id'=> $request->shop_id])->first()->user_id;
            if($request->user->id != $user_id){
                return response()->json(['result'=>'UNPROCESSABLE ENTITY','user'=>$user],422);
            }else {
            
                try {
                    DB::beginTransaction();

                    $ShopMagic =ShopMagic::create([
                        'shop_id' => $request->shop_id,
                        'magic_id' => $request->magic_id,
                    ]);
                    
                    DB::commit();
                    return response()->json(['result'=>"Created",'user'=>$user],201);

                } catch(Exception $exception){
                    DB::rollback();
                    return response()->json(['result'=>"Database error",'user'=>$user],507);
                }
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
