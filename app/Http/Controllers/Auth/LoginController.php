<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request){
        
        $remember_me = $request->has('remember') ? true : false;

       if(Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember_me)){
            return redirect()->route('home');
       }

       return redirect()->route('login')->with('error', 'Username & Password Anda Salah');   
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('login');
    }

    public function register(){
        return view('auth.register');
    }

    public function registerStore(UserRequest $request){

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        
        User::create($data);

        return redirect()->route('login')->withSuccess('User Succesfully Registered');
    }
}
