<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed id
 */
class ServiceIdRequest extends FormRequest
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
            'id' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Требуется указать ID сервиса',
            'id.integer' => 'ID сервиса должно быть целым чилом',
            'id.min' => 'ID сервиса должно быть положительным',
        ];
    }
}
