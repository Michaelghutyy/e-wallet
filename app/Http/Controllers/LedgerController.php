<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ledger;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()){
            if($request->user_id != null){
                $query = Transaction::with('user')->where('user_id', $request->user_id)->where('status', 'Success')->get();
                if($request->start_date != null && $request->end_date != null){
                    $query = Transaction::with('user')->where('user_id', $request->user_id)->whereBetween('created_at', [$request->start_date, $request->end_date])->where('status', 'Success')->get();
                }
            }else if($request->start_date != null){
                $query = Transaction::with('user')->whereBetween('created_at', [$request->start_date, $request->end_date])->where('status', 'Success')->get();
            }else if(Auth::user()->roles == 'customer') {
                $query = Transaction::with('user')->where('user_id', Auth::user()->id)->where('status', 'Success')->get();
            }else{
                $query = Transaction::with('user')->where('status', 'Success')->get();
            }
            return DataTables::of($query)
            ->addColumn('debit', function($item){
                if($item->wallet_type == 'deposit'){
                    return '
                        <div class="">Rp. '.number_format($item->amount,0,',','.').',-</div>
                    ';
                }else{
                    return "
                        <div class=''>Rp. ".number_format(0,0,',','.').",-</div>
                    ";
                }
            })
            ->editColumn('kredit', function($item){
                if($item->wallet_type == 'withdraw'){
                    return '
                        <div class="">Rp. '.number_format($item->amount,0,',','.').',-</div>
                    ';
                }else{
                    return "
                        <div class=''>Rp. ".number_format(0,0,',','.').",-</div>
                    ";
                }
            })
            ->editColumn('total', function($item){
                return "
                    <div>Rp.".number_format($item->total,0,',','.').",-</div>
                ";
            })
            ->editColumn('created_at', function($item){
                return Carbon::parse($item->created_at)->format('d M Y H:i:s');
            })
            ->rawColumns(['debit','kredit','created_at', 'total'])
            ->addIndexColumn()
            ->make();
        }

        return view('pages.ledgers.index', [
            'dataUser' => User::where('roles', 'customer')->get(),
            'transaction' => Transaction::where('user_id', Auth::user()->id)->get()->max(),
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
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
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
