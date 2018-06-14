<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertiesRequest extends FormRequest
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
            'txt_case_type'=>'required',
            'txt_cpu_type'=>'required',
            'sl_cpu_manu'=>'required',
            'txt_driver'=>'required',
            'sl_drive_type'=>'required'
        ];
    }
    public function messages(){
        return [
            'txt_case_type.required'=>'Case type is required',
            'txt_cpu_type.required'=>'Cpu type is required',
            'sl_cpu_manu.required'=>'Cpu Manufacture is required',
            'txt_driver.required'=>'Driver Capacity is required',
            'sl_drive_type.required'=>'Driver Type is required'
        ];
    }
}
