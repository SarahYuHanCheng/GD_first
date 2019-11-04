<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;


class TransactionController extends Controller
{

    // type=[1轉帳 2匯款 3存款 4提款 5...]


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::with(['payer', 'payee', 'type', 'amount'])
            ->orderBy('created_at', 'desc')
            ->paginate();

        return $transactions;
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
        try {
            $out = new \Symfony\Component\Console\Output\ConsoleOutput();
            $out->writeln("transaction store");
            //check two accounts avaiable
            //check payer balance enough to pay
            $payer = Account::where('id', $request->input('payer'))->first();
            $payee = Account::where('id', $request->input('payee'))->first();
                
            $amount = $request->input('amount');
            
            if($payer && $payee){
                if($payer->balance > $amount){
                    try {
                        $transaction = Transaction::create([
                            'payer' => $payer->id,
                            'payee' => $payee->id,
                            'currency_code'=>$request->input('currency_code', ''),
                            'amount' => $request->input('amount', 0),
                            'type' => $request->input('type', 0),
                        ]);
                        $payer->update('balance', $payer->balance-$amount);
                        $payee->update('balance', $payee->balance+$amount);
                        dd($transaction);
                    } catch (\Throwable $th) {
                        //rollback
                        echo $th;
                    }
                }else {
                        return "balance isnot enough";
                    }
            }else {
            return "the account is not exist";
            }
            return $transaction->id() ;
        } catch (\Throwable $th) {
            //throw $th;
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
        $transactions = Transaction::where('payee', $id)
            ->orWhere('payer', $id)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return $transactions;
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
