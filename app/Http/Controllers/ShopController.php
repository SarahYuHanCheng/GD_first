<?php

namespace App\Http\Controllers;

use App\Models\Magic;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\ShopMagic;
use App\Models\UserMagic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Shop::get();
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
        $user = $request->user->only('id','name','balance');
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
        ]);

        if ($validator->fails()) {
            $out->writeln('failed: '.$validator->messages());
            return response()->json(['result'=>$validator->messages(),'user'=>$user],406);
        }else {
            try {
                DB::beginTransaction();

                $shop = Shop::create([
                    'name' => $request->name,
                    'user_id' => $user['id'],
                ]);

                DB::commit();
                return response()->json(['result'=>'Created','user'=>$user,'shop'=>$shop->only('id','name')],201);
            } catch(Exception $exception){
                DB::rollback();
                $out->writeln('exception'.$exception);
                return response()->json(['result'=>'DB error'],500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $id)
    {
        // //list all magic, tag the bought magic , join magic table and usermagic table
      
        if ($id==2) {
            $magics = "[
            {
                \"id\": 1,
                \"photo\":\"R.drawable.m0\",
                \"name\": \"隱身術\",
                \"price\": \"100\",
                \"level\": 1,
                \"magic_id\": 1
                },
                {
                \"id\": 2,
                \"photo\":\"R.drawable.m1\",
                \"name\": \"無所遁形術\",
                \"price\": \"200\",
                \"level\": 1,
                \"magic_id\": null
                },
                {
                \"id\": 3,
                \"photo\":\"R.drawable.m2\",
                \"name\": \"光劍\",
                \"price\": \"50\",
                \"level\": 2,
                \"magic_id\": null
                },
                {
                \"id\": 4,
                \"photo\":\"R.drawable.m3\",
                \"name\": \"光劍\",
                \"price\": \"200\",
                \"level\": 3,
                \"magic_id\": 4
                },
                {
                \"id\": 5,
                \"photo\":\"R.drawable.m4\",
                \"name\": \"光劍\",
                \"price\": \"250\",
                \"level\": 3,
                \"magic_id\": null
                },
                {
                \"id\": 6,
                \"photo\":\"R.drawable.m5\",
                \"name\": \"光劍\",
                \"price\": \"50\",
                \"level\": 2,
                \"magic_id\": null
                },
                {
                \"id\": 7,
                \"photo\":\"R.drawable.m6\",
                \"name\": \"光劍\",
                \"price\": \"50\",
                \"level\": 1,
                \"magic_id\": 7
                }]";
        }else {
              $magics = ShopMagic::where(['shop_id' => $id])
            ->join('magics','shop_magics.magic_id', '=', 'magics.id')
            ->leftjoin('user_magics', function($join){
                $join->where('user_magics.user_id','=', Auth::user()->id)
                ->on('shop_magics.magic_id', '=', 'user_magics.magic_id');
            })
            ->select('magics.id','magics.name','magics.price','magics.level','user_magics.magic_id')
            ->get();
        }
        

        return $magics;
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
        $shop = Shop::where('id',$id)->first();

        return response()->json(['user'=>$request->user,'shop'=>$shop]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $shop = Shop::where('id',$id)->first();
        $shop->delete();
        return response()->json(['user'=>$request->user,'shop'=>$shop]);
    }
}
