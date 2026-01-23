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
        return [
            'image' => [
            'required',
            app()->environment('testing') ? 'file' : 'mimes:jpeg,png'
            ],
            'categories' => ['required', 'array', 'min:1'],
            'condition_id' => ['required'],
            'name' => ['required'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '画像は必須です',
            'image.mimes' => 'jpegまたはpng形式の画像を選択してください',
            'categories.required' => 'カテゴリーは必須です',
            'condition_id.required' => '商品の状態は必須です',
            'name.required' => '商品名は必須です',
            'description.required' => '商品の説明は必須です',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '価格は必須です',
            'price.integer' => '価格は数字で入力してください',
            'price.min' => '価格は0円以上で入力してください',
        ];
    }
}
