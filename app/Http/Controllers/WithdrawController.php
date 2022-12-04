<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
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
        return view('pages.withdraw.payment', [
            'transaction' => Transaction::where('user_id', Auth::user()->id)->get()->max(),
        ]);
    }

    public function paymentProses(Request $request){
        // Mengambil Data type payment e.g BCA, BRI, redirect ke view withdraw create
        return view('pages.withdraw.create', [
            'dataUser' => User::where('roles', 'customer')->get(),
            'transaction' => Transaction::where('user_id', )->where('status', 'success')->get()->max(),
            'type' => $request->type
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $newestData = Transaction::where('user_id', $request->user_id)->get()->max();
        if($newestData == null){
            return redirect()->route('transaction.index')->with('error', 'Anda Tidak Dapat Melakukan Withdraw');
        }else{
            if($newestData->total >= $request->amount){ 
                if($request->status == 'Success'){
                    $data['total'] =  $newestData->total - $request->amount;
                }else{
                    $data['total'] = $newestData->total;
                }
            }else{
                return redirect()->route('transaction.index')->with('error', 'Saldo Anda Tidak Mencukupi Untuk Melakukan Withdraw');
            }
        }
        Transaction::create($data);

        return redirect()->route('transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Redirect ke withdraw payment
       
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

}
