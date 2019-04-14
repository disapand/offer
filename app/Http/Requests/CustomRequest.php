<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'email|nullable',
            'number' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请填写用户名',
            'email.email' => '请输入正确的邮箱格式',
            'number.required' => '请输入电话号码',
        ];
    }
}
