<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class POSITION_SET extends FormRequest
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
            //
            'name'=>'required',
            'introduction'=>'required',
            'pict'=>'mimes:jpeg,png,jpg,bmp,gif',
        ];
    }
    public function attributes(){
        return [
            'name'=>'名前',
            'introduction'=>"紹介文",
            'pict'=>"画像"
        ];
    }
    public function messages(){
        return [
            'name.required'=>":attributeを入力してください。",
            'introduction.required'=>":attributeを入力してください。"
        ];
    }
}
