<?php

namespace App\Http\Requests\Admin\Order;

use App\Helpers\Config\ContractDocConfig;
use App\Http\Rules\Admin\IsEitherSalesperson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateOrderRequest extends FormRequest
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
            'order_id'       => ['required', 'exists:orders,id'],
            'admin_id'       => ['nullable', new IsEitherSalesperson()],
            'user_id'       => ['required', 'exists:users,id'],
            'service_id'    => ['required', 'exists:services,id'],
            'price'         => ['required', 'numeric'],
            'quantity'      => ['required', 'numeric'],
            'note'          => ['required', 'max:500'],
            'document'  => [
                'nullable',
                File::types(ContractDocConfig::fileExtensions())
                    ->min(ContractDocConfig::minFileSize())
                    ->max(ContractDocConfig::maxFileSize()),
            ],
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
            'order_id.required'     => trans('Order is required'),
            'order_id.exists'       => trans('Order does not exists'),
            'user_id.required'      => trans('Customer is required'),
            'user_id.exists'        => trans('Customer does not exists'),
            'service_id.required'   => trans('Service is required'),
            'service_id.exists'     => trans('Service does not exists'),
            'price.required'        => trans('Price is required'),
            'price.numeric'         => trans('Price must be number'),
            'quantity.required'     => trans('Quantity is required'),
            'quantity.numeric'      => trans('Quantity must be number'),
            'note.max'              => trans('Note must not exceed 500 characters'),
        ];
    }
}
