<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => ['required','string','max:50'],
            'email' => ['required','string','email','unique:users,email','max:100'],
            'password' => ['required','string','digits_between:8,12'],
        ];
    }



    public function messages()
    {
        return [
            'name.required' => '店舗代表者名を入力してください',
            'name.string' => '文字列で入力してください',
            'name.max' => '50文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.string' => '文字列で入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.unique' => 'このメールアドレスは既に使われています',
            'email.max' => '100文字以内で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.string' => '文字列で入力してください',
            'password.digits_between' => '8桁から12桁で入力してください',
        ];
    }
}
