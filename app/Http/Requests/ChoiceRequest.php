<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ChoiceRequest extends FormRequest
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
        $rules = [
            'text' => ['required', 'string', 'max:255'],
            'next_scene_id' => ['required', 'exists:scenes,id'],
            'min_energy_required' => ['required', 'integer', 'min:0'],
            'min_alignment_required' => ['nullable', 'integer'],
            'max_alignment_required' => ['nullable', 'integer'],
            'min_affection_required' => ['required', 'integer', 'min:0'],
            'energy_change' => ['required', 'integer'],
            'alignment_change' => ['required', 'integer'],
            'affection_change' => ['required', 'integer'],
        ];

        if($this->filled('min_alignment_required')){
            $rules['max_alignment_required'][] = 'gte:min_alignment_required';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'text.required' => 'テキストが不足しています。',
            'text.max' => 'テキストの文字数制限を超えています。',
            'next_scene_id.required' => '遷移先シーンの設定は必須です。',
            'next_scene_id.exists' => '遷移先シーンが存在しません。',
            'min_energy_required.required' => '出現最低行動力の設定は必須です。',
            'min_energy_required.min' => '出現最低行動力は０以上の数値を設定してください。',
            'max_alignment_required.gte' => '出現最高異形度は、出現最低異形度以上の数値を入力してください。',
            'min_affection_required.required' => '出現最低友好度の設定は必須です。',
            'min_affection_required.min' => '出現最低友好度は０以上の数値を設定してください。',
            'energy_change.required' => '行動力変化の設定は必須です。',
            'alignment_change.required' => '異形度変化の設定は必須です。',
            'affection_change.required' => '友好度変化の設定は必須です。',
        ];
    }
}
