<?php

namespace App\Http\Rules\Admin;

use App\Models\Admin;
use App\Models\Lead;
use App\Services\Admin\OrderService;
use Illuminate\Contracts\Validation\Rule;

class IsNextOrderPipeline implements Rule
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
        $pipeline = (new OrderService())->getNextPipelineByOrderId($this->orderId);

        if (!$pipeline) {
            $this->message = trans("Invalid");
            return false;
        }

        if ($pipeline->id != $pipelineId) {
            $this->message = trans("Invalid");
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
