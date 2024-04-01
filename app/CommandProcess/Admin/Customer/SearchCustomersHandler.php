<?php

namespace App\CommandProcess\Admin\Customer;

use App\Http\Resources\Admin\Customer\CustomerResource;
use App\Services\Admin\CustomerService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class SearchCustomersHandler implements Handler
{
    private CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function handle(Command $command)
    {
        return $this->customerService->searchCustomers($command->filters);

        /*$users = [];
        foreach ($customers as $customer) {
            $users[] = new CustomerResource($customer);
        }
        return $users;*/

//        return CustomerResource::collection($customers);
    }
}
