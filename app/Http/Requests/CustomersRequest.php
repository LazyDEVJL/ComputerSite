<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomersRequest extends FormRequest
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
        return [
            'username' =>'required|unique:tbl_customers',
            'txt_name'=>'required',
            'txt_pass'=>'required|min:6',
            'txt_pass_confirm'=>'required|same:txt_pass',
            'txt_phone'=>'required',
            'txt_email'=>'required',
            'txt_address'=>'required'
        ];
    }

    public function messages(){
        return [
            'username.required'=>'Username is required',
            'username.unique'=>'This username already been taken',
            'txt_name.required'=>'Name is required',
            'txt_pass.required'=>'Password is required',
            'txt_pass.min'=>'Password must be atleast 6 characters',
            'txt_pass_confirm.required'=>'Password confirm is required',
            'txt_pass_confirm.same'=>'Password confirm must match with password',
            'txt_phone.required'=>'Phone number is required',
            'txt_email.required'=>'Email is required',
            'txt_address.required'=>'Phone number is required'
        ];
        
    }

    
}
