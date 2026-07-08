<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class AssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:20480'],
            'type' => ['required', 'string', 'in:image,bgm,se'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'name.required' => '素材の名前は必須です。',
            'name.max' => '名前は255文字以内で入力してください。',
            'file.required' => 'ファイルを選択してください。',
            'file.max' => 'ファイルサイズは20MB以内でアップロードしてください。',
            'type.required' => '種類は必須です。',
            'type.in' => '種類はimage, bgm, seのいずれかを設定してください。',
        ];
    }
}
