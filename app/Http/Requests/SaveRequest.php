<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
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
            'slot' => ['required', 'integer', 'in:0,1,2'],
            'scene_id' => ['required', 'integer'],
            'step_order' => ['required', 'integer'],
            'energy' => ['required', 'integer'],
            'alignment' => ['required', 'integer'],
            'affection' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return[
            'slot.required' => 'セーブスロットが指定されていません。',
            'slot.in' => '無効なセーブスロットです。',
            'scene_id.required' => 'シーンIDが不足しています。',
            'step_order.required' => '進行度が不足しています。',
            'energy.required' => '体力の値が不足しています。',
            'alignment.required' => '異形度の値が不足しています。',
            'affection.required' => '好感度の値が不足しています。',
        ];
    }
}
