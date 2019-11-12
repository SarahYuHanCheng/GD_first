<?php

namespace App\Http\Controllers;

use App\Models\Magic;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\ShopMagic;
use App\Models\UserMagic;
use Illuminate\Support\Facades\Auth;

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
        return Shop::create([
            'name' => $request->name,
            'user_id' => $request->user->id,
        ]);
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
            $magics = " [
                MagicBook(id: 0, name: \"保護罩\", level: 1, price: 100),
                MagicBook(id: 1, name: \"光箭\", level: 1, price: 100),
                MagicBook(id: 2, name: \"冰箭\", level: 1, price: 100),
                MagicBook(id: 3, name: \"初級治癒術\", level: 1, price: 100),
                MagicBook(id: 4, name: \"指定傳送\", level: 1, price: 100),
                MagicBook(id: 5, name: \"日光術\", level: 1, price: 100),
                MagicBook(id: 6, name: \"神聖武器\", level: 1, price: 100),
                MagicBook(id: 7, name: \"風刃\", level: 1, price: 100),
                MagicBook(id: 8, name: \"地獄之牙\", level: 2, price: 300),
                MagicBook(id: 9, name: \"寒冷戰慄\", level: 2, price: 300),
                MagicBook(id: 10, name: \"擬似魔法武器\", level: 2, price: 300),
                MagicBook(id: 11, name: \"毒咒\", level: 2, price: 300),
                MagicBook(id: 12, name: \"火箭\", level: 2, price: 300),
                MagicBook(id: 13, name: \"無所遁形術\", level: 2, price: 300),
                MagicBook(id: 14, name: \"解毒術\", level: 2, price: 300),
                MagicBook(id: 15, name: \"負重強化\", level: 2, price: 300),
                MagicBook(id: 16, name: \"中級治癒術\", level: 3, price: 500),
                MagicBook(id: 17, name: \"寒冰氣息\", level: 3, price: 500),
                MagicBook(id: 18, name: \"極光雷電\", level: 3, price: 500),
                MagicBook(id: 19, name: \"能量感測\", level: 3, price: 500),
                MagicBook(id: 20, name: \"起死回生術\", level: 3, price: 500),
                MagicBook(id: 21, name: \"鎧甲護持\", level: 3, price: 500),
                MagicBook(id: 22, name: \"闇盲咒術\", level: 3, price: 500)
            ]";
            //   $magics = ShopMagic::where(['shop_id' => $id])
            // ->join('magics','shop_magics.magic_id', '=', 'magics.id')
            // ->leftjoin('user_magics', function($join){
            //     $join->where('user_magics.user_id','=', Auth::user()->id)
            //     ->on('shop_magics.magic_id', '=', 'user_magics.magic_id');
            // })
            // ->select('magics.id','magics.name','magics.price','magics.level','user_magics.magic_id')
            // ->get();
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
