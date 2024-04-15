<?php

namespace App\CommandProcess\Admin\Order;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\Customer\CustomerResource;
use App\Http\Resources\Admin\RoleResource;
use App\Models\Lead;
use App\Models\Order;
use App\Services\Admin\CustomerService;
use App\Services\Admin\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class CreateLeadCustomerHandler implements Handler
{


    private CustomerService $dbService;

    public function __construct(CustomerService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        if (isset($command->data['dob'])) {
            $command->data['dob'] = getGlobalDate($command->data['dob']);
        }
        $customer = $this->dbService->save($command->data);

        Order::where('id', $command->data['order_id'])->update(['user_id' => $customer->id]);
        Lead::where('id', $command->data['lead_id'])->update([
            'is_converted' => 1,
            'converted_to' => $customer->id,
            'converted_at' => getCurrentDateTime(),
        ]);

        return new CustomerResource($customer);
    }
}
