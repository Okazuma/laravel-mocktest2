<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagementRequest extends FormRequest
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
            'name' => ['required','string','max:100'],
            'description' => ['required','string','max:255'],
            'area' => ['required'],
            'genre' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '飲食店名を入力してください',
            'name.string' => '文字列で入力してください',
            'name.Max' => '100文字以内で入力してください',

            'description.required' => '飲食店情報を入力してください',
            'description.string' => '文字列で入力してください',
            'description.Max' => '255文字以内で入力してください',

            'area.required' => 'エリアを選択してください',

            'genre.required' => 'ジャンルを選択してください',

        ];
    }
}
