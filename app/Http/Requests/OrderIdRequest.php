<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed id
 */
class OrderIdRequest extends FormRequest
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
            'id' => 'required|exists:orders_collection,order_id'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Требуется указать ID заказа',
            'id.exists' => 'ID заказа не найдено',
        ];
    }
}
