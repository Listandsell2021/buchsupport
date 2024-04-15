<?php

namespace App\Http\Requests\Admin\Order;

use App\Http\Rules\Admin\IsNextOrderPipeline;
use App\Http\Rules\Admin\DoesOrderHaveFillableCondition;
use Illuminate\Foundation\Http\FormRequest;

class ChangeOrderPipelineRequest extends FormRequest
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
                new IsNextOrderPipeline((int) $this->get('order_id')),],
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
        ];
    }
}
