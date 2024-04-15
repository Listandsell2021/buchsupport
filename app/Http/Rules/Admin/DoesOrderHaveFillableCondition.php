<?php

namespace App\Http\Rules\Admin;

use App\Models\Admin;
use App\Models\Lead;
use App\Models\Order;
use App\Models\ServicePipeline;
use App\Services\Admin\OrderService;
use Illuminate\Contracts\Validation\Rule;

class DoesOrderHaveFillableCondition implements Rule
{

    protected int $orderId;
    protected string $message;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param $pipelineId
     * @return bool
     */
    public function passes($attribute, $pipelineId): bool
    {
        $pipeline = ServicePipeline::where('id', $pipelineId)->first();

        if (!$pipeline) {
            $this->message = trans("Service status is invalid");
            return false;
        }
        $order = Order::find($this->orderId);

        if (!$order) {
            $this->message = trans("Invalid order");
            return false;
        }

        if ($pipeline->has_tracking && !$order->shipment_no) {
            $this->message = trans("Shipment no is required");
            return false;
        }

        if ($pipeline->has_conversion && !$order->user_id) {
            $this->message = trans("Customer is required");
            return false;
        }

        return true;
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
