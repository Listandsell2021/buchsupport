<?php

namespace App\CommandProcess\Admin\Customer;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\Customer\CustomerResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreCustomerHandler implements Handler
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

        return new CustomerResource($customer);
    }
}
