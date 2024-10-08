<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImagesRequest extends FormRequest
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
            'images.*' => ['required','image','mimes:jpeg,png','max:5120']
        ];
    }

    public function messages()
    {
        return[
            'images.*.required'  => '画像が選択されていません',
            'images.*.image' => '画像ファイルを選択してください',
            'images.*.mimes' => 'jpeg, png を選択してください',
            'images.*.max' => '最大5MBまでです',
        ];
    }
}
