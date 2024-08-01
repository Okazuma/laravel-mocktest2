<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeRequest extends FormRequest
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
            'subject' => ['required','max:50'],
            'content' => ['required','max:255'],
            'users' => ['required', 'array'],
            'users.*' => ['exists:users,id'],
        ];
    }

    public function messages()
    {
        return [
        'subject.required' => '件名を入力してください',
        'subject.max' => '50文字以内で入力してください',
        'content.required' => '内容を入力してください',
        'content.max' => '255文字以内で入力してください',
        'users.required' => '送信先を選択してください。',
        'users.array' => '送信先は配列として選択してください。',
        'users.*.exists' => '選択されたユーザーが無効です。',
        ];
    }
}
