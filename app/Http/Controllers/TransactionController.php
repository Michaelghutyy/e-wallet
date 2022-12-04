<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax())
        {
            if($request->user_id != null){
                $query = Transaction::with('user')->where('user_id', $request->user_id)->get();
                if($request->start_date != null && $request->end_date != null){
                    $query = Transaction::with('user')->where('user_id', $request->user_id)->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
                }
            }else if($request->start_date != null){
                $query = Transaction::with('user')->whereBetween('created_at', [$request->start_date, $request->end_date])->where('status', 'Success')->get();
            }else if(Auth::user()->roles == 'customer'){
                $query = Transaction::with('user')->where('user_id', Auth::user()->id)->get();
            }else{
                $query = Transaction::with('user')->get();
            }
            return DataTables::of($query)
            ->addColumn('action', function($item){
                if(Auth::user()->roles == 'admin'){
                    return '
                    <button class="btn btn-'.($item->status == 'Success' ? 'secondary' : 'success').'  btn-label update-status" data-id="' . $item->id . '">
                        <i class="mdi mdi-cup label-icon"></i>'. ($item->status == 'Success' ? 'Pending' : 'Success') .'    
                    </button>
                    <a class="btn btn-info btn-label" href="' . route('transaction.edit', $item->id) . '">
                        <i class="mdi mdi-pencil label-icon align-middle"></i> Ubah
                    </a>
                    <button class="btn btn-danger  btn-label delete-data" data-id="' . $item->id . '">
                        <i class="mdi mdi-cup label-icon"></i> Hapus    
                    </button>
                    ';
                }
            })
            ->editColumn('amount', function($item){
                if($item->wallet_type == 'deposit'){
                    return '
                        <div class="text-success">+Rp.'.number_format($item->amount,0,',','.').',-</div>
                    ';
                }else{
                    return "
                        <div class='text-danger'>-Rp.".number_format($item->amount,0,',','.').",-</div>
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
            ->rawColumns(['created_at', 'action', 'amount', 'total'])
            ->addIndexColumn()
            ->make();
        }

        return view('pages.transactions.index', [
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
        return view('pages.transactions.create', [
            'dataUser' => User::where('roles', 'customer')->get(),
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
            // $data['total'] = $request->amount;
            $data['total'] = 0;
        }else{
            $data['total'] = $newestData->total;
        }
        Transaction::create($data);

        return redirect()->route('transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('pages.transactions.edit', [
            'dataUser' => User::where('roles', 'customer')->where('id', $transaction->user_id)->get(),
            'dataTransaction' => $transaction,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->all();
        $newestData = Transaction::where('user_id', $request->user_id)->where('status', 'Success')->get()->max();
        $validasiDataID = Transaction::where('user_id', $request->user_id)->where('status', 'Success')->where('wallet_type', $transaction->wallet_type)->get();
        
        if($newestData != null){
            if($transaction->wallet_type == 'deposit'){
                
                if($request->status == "Success" && $newestData->total != null){
                    if($validasiDataID->count() > 1){
                        $data['total'] = ($newestData->total - $newestData->amount) + $request->amount;
                    }else{
                        $data['total'] = $newestData->total + $request->amount;
                    }
                }else{
                    $data['total'] = $newestData->total;
                }
            }else if($transaction->wallet_type == 'withdraw'){
                if($newestData->total >= $request->amount){ // Mengecek apakah request user lebih besar dari balance
                    if($request->status == "Success" && $newestData->total != null){ //mengecek apakah ada data total
                        if($validasiDataID->count() >= 1){
                            $data['total'] = ($newestData->total + $newestData->amount) - $request->amount;
                        }else{
                            $data['total'] = $newestData->first()->total - $request->amount;
                        }   
                    }else{
                        $data['total'] = $newestData->total;
                    }
                }else{
                    return redirect()->route('transaction.index')->with('error', 'Saldo Anda Tidak Mencukupi Untuk Melakukan Withdraw');
                }
            }else{
                return redirect()->route('transaction.index')->with('error', 'Data Tidak Dapat Diedit');
            }
        }else{
            if($request->status == 'Success'){
                $data['total'] = $request->amount;
            }
        }


        $transaction->update($data);

        if(Auth::user()->roles == 'admin'){
            return redirect()->route('transaction.index');
        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        
        $cekData = Transaction::where('user_id', $transaction->user_id)->get()->max();

        if($cekData->id == $transaction->id){
            $data = $transaction->delete();
            return response()->json($data);
        }else{
            return response()->json('', 400);
        }
    }

    public function updateStatus($id){
        $data = Transaction::findorFail($id);

        $status = "Pending";
        if($data->status == 'Pending'){
            $status = "Success";
            
            if($data->wallet_type == 'deposit'){
                $data->total += $data->amount;
            }else{
                $data->total -= $data->amount;
            }
        }else{
            $status = "Pending";
        }

        $data->status = $status;
        $data->update();

        return response()->json(true);
    }
}
