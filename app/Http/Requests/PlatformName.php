<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed name
 */
class PlatformName extends FormRequest
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
            'name' => 'required|exists:platform_collection,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Требуется указать название платформы',
            'name.exists' => 'Неизвестаная платформа!',
        ];
    }
}
