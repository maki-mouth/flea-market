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
        return [
            'profile_image' => ['nullable', 'mimes:png,jpg'],
            'name' => ['required', 'max:20'],
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'profile_image.image' => 'プロフィール画像は画像ファイルである必要があります',
            'profile_image.mimes' => 'jpegまたはpng形式の画像を選択してください',
            'name.required' => '名前は必須です',
            'name.max' => '名前は20文字以内で入力してください',
            'postal_code.required' => '郵便番号は必須です',
            'postal_code.regex' => '郵便番号はハイフン付きの8文字で入力してください',
            'address.required' => '住所は必須です',
        ];
    }
}
