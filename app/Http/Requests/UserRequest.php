<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        if(in_array($this->method(), ['PUT', 'PATCH'])){
            $rules = [
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
                'confirm_password' => 'required|same:password'
              ];
        }else{
            $rules = [
                'name' => 'required|unique:users,name',
                'username' => 'required|unique:users,username',
                'password' => 'required',
                'confirm_password' => 'required|same:password'
              ];
        }
        return $rules;
    }
    
    public function messages()
    {
        return [
            'name.unique'           => 'Nama telah digunakan',
            'username.unique'          => 'Username telah digunakan',
            'password.required'     => 'Password tidak boleh kosong',
            'confirm_password.same' => 'Password tidak sama',
            'confirm_password.required' => 'Password tidak boleh kosong',
        ];
    }
}
