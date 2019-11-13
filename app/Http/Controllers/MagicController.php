<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magic;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DB;

class MagicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->belongsTo(User::class);
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
            'name' => 'required|max:25',
            'price' => 'required|integer|5',
            'level' => 'required|integer|max:2',
        ]);
        $user = $request->user->only('name','balance');
        if ($validator->fails()) {

            return response()->json(['result'=>$validator->messages(),'user'=>$user],406);
        }else {
            try {
                DB::beginTransaction();
                $magic = Magic::create([
                    'name' => $request->name,
                    'price' => $request->price,
                    'level' => $request->level,
                ]);
                DB::commit();
                return response()->json(['result'=>'Created','magic'=>$magic,'user'=>$user],201);
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['result'=>'Database error','user'=>$user],507);
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
