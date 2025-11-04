<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
        $rules['image'] = 'required|image|mimes:jpeg,png';
        return $rules;
    }

    public function messages()
    {
        return [
            'image.required' => 'プロフィール画像をアップロードしてください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '画像ファイルの拡張子は「jpeg」または「png」を指定してください',
        ];

    }
}
