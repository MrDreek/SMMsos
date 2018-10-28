<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_id' => 'required|string',
            'service_id' => 'required|integer|min:1',
            'count' => 'required|integer|min:1',
            'url' => 'required|string',
            'options' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Требуется указать ID пользователя',
            'user_id.string' => 'ID пользователя должно быть строкой',
            'service_id.required' => 'Требуется указать ID сервиса',
            'service_id.integer' => 'ID сервиса должно быть целым чилом',
            'service_id.min' => 'ID сервиса должно быть положительным',
            'count.required' => 'Требуется указать Количество',
            'count.integer' => 'Количество должно быть целым чилом',
            'count.min' => 'Количество быть положительным',
            'url.required' => 'Требуется указать url',
            'url.integer' => 'url должен быть строкой',
            'options.integer' => 'url должен быть строкой'
        ];
    }
}
