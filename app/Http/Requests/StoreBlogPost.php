<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
            'name' => 'required|unique:user|max:255',
            'sex' => 'required|integer',
        ];
    }
    public function messages(){
        return [
            'name.required' => '用户名必填',
            'name.unique' => '用户名已存在',
            'sex.required' => '性别要填',
        ];
    }

}
