<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\User;
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln("account index");
        $accounts = Account::where('user_id', $request->input('user_id'))->get();
        return response()->json(['accounts'=>$accounts]);
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
        $out->writeln("store");

        
        $account = Account::create([
            'user_id' => $request->input('user_id', ''),
            'currency_code' => $request->input('currency_code', ''),
            'balance' => $request->input('balance', 0),
        ]);
        $data = [
            'account_id' =>$account->id,
            'balance' =>$request->input('balance', 0) ,
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        $account = Account::find($id);
        if($account->user_id==$request->user->id){
            
            $history = $account->transactionHistory();
            
            // $out->writeln("right user".$history);
            
            $sub=$history->map(function ($history) {
                return collect($history->toArray())
                    ->only(['id', 'payer', 'payee','amount'])
                    ->all();
            });
            return $sub;
        }else{
            $out->writeln("not the user");
        }
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
