<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StepRequest extends FormRequest
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
            'step_order' => ['required', 'integer', 'min:1'],
            'text' => ['required', 'string', 'max:1000'],
            'bg_image' => ['nullable', 'string'],
            'bgm' => ['nullable', 'string'],
            'se' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return[
            'step_order.required' => '順序が指定されていません。',
            'step_order.min' => '順序が既定の範囲から外れています。',
            'text.required' => 'テキストが不足しています。',
            'text.max' => 'テキストの文字数制限を超えています。',
        ];
    }
}
