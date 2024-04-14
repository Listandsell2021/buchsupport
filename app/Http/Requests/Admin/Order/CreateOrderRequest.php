<?php

namespace App\Http\Requests\Admin\Order;

use App\Helpers\Config\ContractDocConfig;
use App\Http\Rules\Admin\CheckProductImages;
use App\Models\ServicePipeline;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreateOrderRequest extends FormRequest
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
            'user_id'       => ['required', 'exists:users,id'],
            'service_id'    => ['required', 'exists:services,id'],
            'price'         => ['required', 'numeric'],
            'quantity'      => ['required', 'numeric'],
            'note'          => ['required', 'max:500'],
            'document'  => [
                'required',
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
            'name.required'         => trans('Service name is required'),
            'name.unique'           => trans('Service name already exists'),
            'is_active.required'    => trans('Status is required'),
        ];
    }
}
