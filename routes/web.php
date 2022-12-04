<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });

route::get('/register', [LoginController::class, 'register'])->name('register');
route::post('/register/store', [LoginController::class, 'registerStore'])->name('register.store');

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/todoLogin', [LoginController::class, 'login'])->name('todo-login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

Route::resource('users', UsersController::class);
Route::resource('transaction', TransactionController::class);
Route::post('transaction/updateStatus/{id}', [TransactionController::class, 'updateStatus']);
Route::resource('deposit', DepositController::class);
Route::resource('withdraw', WithdrawController::class);
Route::resource('ledgar', LedgerController::class);

Route::post('deposit/payment', [DepositController::class, 'paymentProses'])->name('deposit.paymentProses');
Route::post('withdraw/payment', [WithdrawController::class, 'paymentProses'])->name('withdraw.paymentProses');
