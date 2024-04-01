<?php

namespace App\CommandProcess\Admin\Customer;

use App\Services\Admin\CustomerService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class SortCustomerProductsHandler implements Handler
{
    private CustomerService $customerService;

    /**
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function handle(Command $command)
    {
        $this->customerService->sortProducts($command->userProductIds);
    }

}
