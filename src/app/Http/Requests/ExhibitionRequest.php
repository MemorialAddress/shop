<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
        $rules['item_name'] = 'required';
        $rules['item_describe'] = 'required|max:255';
        $rules['condition'] = 'required';
        $rules['price'] = 'required|numeric|min:1';
        $rules['image'] = 'required';
        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $categories = [];
            for ($i = 1; $i <= 14; $i++) {
                $categories[] = $this->input("category{$i}");
            }

            if (!collect($categories)->contains(function ($value) { return $value && $value !== '0'; })) {
                $validator->errors()->add('category', 'カテゴリは1つ以上選択してください。');
            }
        });
    }
    public function messages()
    {
        return [
            'item_name.required' => '商品名を入力してください',
            'item_describe.required' => '商品説明を入力してください',
            'item_describe.max' => '商品説明は255文字以下で入力してください',
            'condition.required' => '商品状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.numeric' => '商品価格は数値で入力してください',
            'price.min' => '商品価格は1円以上で入力してください',
            'image.required' => '商品画像をアップロードしてください',
        ];

    }
}
