<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'account' => 'required|string|unique:users,account',
            'username' => 'required|string',
            'password' => 'required|string|min:6',
            'sign' => 'required|unique:users,sign'
        ];
    }

    public function messages()
    {
        return [
            'account.required' => '请输入账号',
            'account.unique' => '该账号已存在，请直接登录',
            'username.required' => '请输入用户名',
            'password.required' => '请输入密码',
            'password.min' => '密码长度过低',
            'sign.required' => '请输入标记',
            'sign.unique' => '标记已存在，请重新输入'
        ];
    }
}
