<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed name
 */
class CategoryName extends FormRequest
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
            'category' => 'required|exists:category_collection,name',
            'platform' => 'required|exists:platform_collection,name',
        ];
    }

    public function messages()
    {
        return [
            'category.required' => 'Требуется указать имя категории',
            'category.exists' => 'Имя категории не найдено!',
            'platform.required' => 'Требуется указать платформу',
            'platform.exists' => 'Платформа не найдена!',
        ];
    }
}
