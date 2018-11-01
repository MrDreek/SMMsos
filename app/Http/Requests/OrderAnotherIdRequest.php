<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed id
 */
class OrderAnotherIdRequest extends FormRequest
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
            'id' => 'required|exists:orders_collection,_id'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Требуется указать ID заказа',
            'id.exists' => '_ID заказа не найдено',
        ];
    }
}
