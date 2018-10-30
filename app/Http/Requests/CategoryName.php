<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|exists:category_collection,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Требуется указать имя категории',
            'name.exists' => 'Имя категории не найдено!',
        ];
    }
}
