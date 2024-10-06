<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportCsvRequest extends FormRequest
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
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'csv_file.required' => 'csvファイルが選択されていません',
            'csv_file.mimes' => 'CSVファイルまたはテキストファイルを選択してください',
            'csv_file.max' => 'CSVファイルのサイズは2MB以下でなければなりません。',
        ];
    }
}
