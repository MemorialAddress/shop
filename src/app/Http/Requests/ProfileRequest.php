<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:20',
            'post_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
            'image' => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'image.required' => 'プロフィール画像をアップロードしてください',
            'name.required'    => '名前を入力してください',
            'name.max'    => '名前は20文字以下で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex'    => '郵便番号はハイフン付きで入力してください(例：123-4567）',
            'address.required' => '住所を入力してください'
        ];

    }
}
