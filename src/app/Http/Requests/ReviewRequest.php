<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'restaurant_id' => ['required'],
            'rating' => ['required'],
            'comment' => ['required','string','max:400',],
            'review_image' => ['file', 'mimes:jpeg,png,jpg', 'max:5120'],
        ];
    }



    public function messages()
    {
        return [
            'restaurant_id.required' => '店舗を選択してください',
            'rating.required' => '評価を選んでください',
            'comment.required' => 'コメントを入力してください',
            'comment.string' => '文字列で入力してください',
            'comment.max' => '400文字以内で入力してください',

            'review_image.file' =>'画像ファイルを選択してください',
            'item_image.mimes' => 'jpeg, png, jpg を選択してください',
            'item_image.max' => '画像サイスは5MBまでです',
        ];
    }
}
