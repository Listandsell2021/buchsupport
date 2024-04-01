<?php

namespace App\CommandProcess\Admin\Customer;

use App\Services\Admin\CustomerService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateCustomersBulkActionHandler implements Handler
{

    private CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function handle(Command $command)
    {
        $message = '';

        if ($command->action == 'delete') {
            $this->customerService->deleteBulk($command->customerIds);
            $message = trans('Customers deleted successfully');
        }

        if ($command->action == 'active') {
            $this->customerService->updateBulkActiveStatus($command->customerIds, 1);
            $message = trans('Customers updated with status active successfully');
        }

        if ($command->action == 'inactive') {
            $this->customerService->updateBulkActiveStatus($command->customerIds, 0);
            $message = trans('Customers updated with status inactive successfully');
        }

        return $message;
    }
}
