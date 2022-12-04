<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use App\Models\IncomingItems;
use App\Models\OutcomingItems;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Rend   erable
     */
    public function index()
    {
        if(Auth::user()->roles == 'admin'){
            $transaction = Transaction::all();
            $deposit = Transaction::where('wallet_type', 'deposit')->get();
            $withdraw = Transaction::where('wallet_type', 'withdraw')->get();
        }if(Auth::user()->roles == 'customer'){
            $transaction = Transaction::where('user_id', Auth::user()->id)->get()->max();
            $deposit = Transaction::where('wallet_type', 'deposit')->where('user_id', Auth::user()->id)->where('status', 'Success')->get();
            $withdraw = Transaction::where('wallet_type', 'withdraw')->where('user_id', Auth::user()->id)->where('status', 'Success')->get();
        }

        $lastMonth = CarbonPeriod::create(Carbon::now()->subDays(7), Carbon::now());
        $lastWeekTransactions = [];
        foreach ($lastMonth as $date) {
        $lastWeekTransactions['days'][] = $date->format("l");

            // Data Transaction Per Hari
            if(Auth::user()->roles == 'customer'){
                $a = Transaction::whereDate('created_at', '=', $date)->where('user_id',  Auth::user()->id)->where('status', 'Success')->count();
                if($a != null){
                    $b = Transaction::whereDate('created_at', '=', $date)->where('user_id', Auth::user()->id)->where('status', 'Success')->get();
                    $lastWeekTransactions['transaction'][] = $b->max()->total;
                }else{
                    $lastWeekTransactions['transaction'][] = 0;
                }
            }else{
                $lastWeekTransactions['transaction'][] = Transaction::whereDate('created_at', '=', $date)->count();
            }
        }
        $balance_chart['lastWeekTransactions'] = $lastWeekTransactions;
        
        

        return view('home', [
            'transaction' => $transaction,  
            'customer' => user::where('roles', 'customer'),
            'user' => User::all(),
            'deposit' => $deposit,
            'withdraw' => $withdraw,
            'days' => $balance_chart['lastWeekTransactions']['days'],
            'balance' => $balance_chart['lastWeekTransactions']['transaction'],
        ]);

      
    }
}
