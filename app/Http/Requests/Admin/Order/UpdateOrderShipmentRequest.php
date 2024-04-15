<?php

namespace App\Http\Requests\Admin\Order;

use App\DataHolders\Enum\Gender;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderShipmentRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'order_id'      => ['required', 'exists:orders,id'],
            'shipment_no'   => ['required'],
        ];
    }


    /**
     * Validation Messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'order_id.required' => trans('Order is required'),
            'order_id.exists' => trans('Order does not exists'),
            'shipment_no.required' => trans('Shipment no is required'),
        ];
    }
}
