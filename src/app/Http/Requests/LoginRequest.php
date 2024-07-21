<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required','string','email','max:100'],
            'password' => ['required','string','digits_between:8,12'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.string' => 'メールアドレスを文字列で入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.max' => '100文字以内で入力してください',


            'password.required' => 'パスワードを入力してください',
            'password.string' => 'パスワードは文字列で入力してください',
            'password.digits_between' => '8桁から12桁で入力してください',
        ];
    }
}
