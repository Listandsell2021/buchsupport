<?php

namespace App\Http\Requests\Admin\Order;

use App\DataHolders\Enum\OrderStatus;
use App\Http\Rules\Admin\IsNextOrderPipeline;
use App\Http\Rules\Admin\DoesOrderHaveFillableCondition;
use App\Models\Order;
use App\Models\ServicePipeline;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderToLastPipelineRequest extends FormRequest
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
            'order_id'      => ['required'],
            'pipeline_id'   => [
                'required',
                new DoesOrderHaveFillableCondition((int) $this->get('order_id')),
                new IsNextOrderPipeline((int) $this->get('order_id')),
                function (string $attribute, mixed $value, \Closure $fail) {
                    $pipeline = ServicePipeline::where('service_id', $this->get('service_id'))
                        ->where('id', $value)
                        ->where('has_option', 1)
                        ->first();
                    if (!$pipeline) {
                        $fail("Service status does not exists");
                    }
                },
            ],
            'service_id'    => 'required',
            'status'        => ['required', Rule::in(OrderStatus::onlyNames())],
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
            'pipeline_id.required' => trans('Pipeline is required'),
            'status.required' => __('Pipeline option is required'),
            'status.in' => __('Pipeline option must be one of '.implode(',', OrderStatus::onlyNames())),
        ];
    }
}
